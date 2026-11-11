<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\BookingDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // HALAMAN PILIH KURSI
    public function seats($id)
    {
        $this->expireBookings();
        $schedule = Schedule::with([
            'film',
            'studio.seats'
        ])->findOrFail($id);
        abort_unless($schedule->status === 'active' && $schedule->start_time->isFuture(), 404, 'Jadwal tidak tersedia untuk pemesanan.');

        $bookedSeatIds = BookingDetail::where(
            'schedule_id',
            $schedule->id
        )->pluck('seat_id')->toArray();

        $seats = $schedule->studio->seats
            ->sortBy([
                ['row', 'asc'],
                ['seat_number', 'asc']
            ]);

        return view('seats', compact(
            'schedule',
            'seats',
            'bookedSeatIds'
        ));
    }


    // HALAMAN FORM DATA PEMESAN
    public function form(Request $request, $id)
    {
        $this->expireBookings();
        $request->validate([
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'required|integer|distinct|exists:seats,id',
        ]);

        $schedule = Schedule::with([
            'film',
            'studio'
        ])->findOrFail($id);
        abort_unless($schedule->status === 'active' && $schedule->start_time->isFuture(), 404, 'Jadwal tidak tersedia untuk pemesanan.');

        $seatIds = $request->seat_ids;

        $seats = DB::table('seats')
            ->where('studio_id', $schedule->studio_id)
            ->whereIn('id', $seatIds)
            ->get();

        if ($seats->count() !== count($seatIds)) {
            return back()->withErrors([
                'seat_ids' => 'Kursi tidak valid.'
            ]);
        }

        $alreadyBooked = BookingDetail::where(
            'schedule_id',
            $schedule->id
        )->whereIn('seat_id', $seatIds)->exists();

        if ($alreadyBooked) {
            return back()->withErrors([
                'seat_ids' => 'Ada kursi yang sudah dipesan.'
            ]);
        }

        $total = $seats->count() * $schedule->price;

        return view('booking-form', compact(
            'schedule',
            'seats',
            'seatIds',
            'total'
        ));
    }


    // SIMPAN PEMESANAN
    public function store(Request $request, $id)
    {
        $this->expireBookings();
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:150',
            'customer_phone' => 'required|string|max:20',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'required|integer|distinct|exists:seats,id',
        ]);

        $booking = DB::transaction(function () use (
            $validated,
            $id
        ) {

            $schedule = Schedule::findOrFail($id);
            if ($schedule->status !== 'active' || !$schedule->start_time->isFuture()) {
                throw ValidationException::withMessages(['schedule' => 'Jadwal tidak tersedia untuk pemesanan.']);
            }

            $seatIds = $validated['seat_ids'];

            // Kunci data kursi selama transaksi
            $seats = DB::table('seats')
                ->where('studio_id', $schedule->studio_id)
                ->whereIn('id', $seatIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get();

            if ($seats->count() !== count($seatIds)) {
                throw ValidationException::withMessages([
                    'seat_ids' => 'Kursi tidak valid.'
                ]);
            }

            // Periksa apakah kursi sudah dipesan
            $alreadyBooked = BookingDetail::where(
                'schedule_id',
                $schedule->id
            )->whereIn('seat_id', $seatIds)->exists();

            if ($alreadyBooked) {
                throw ValidationException::withMessages([
                    'seat_ids' => 'Maaf, ada kursi yang baru saja dipesan orang lain.'
                ]);
            }

            $total = $seats->count() * $schedule->price;

            $bookingCode = 'CMX-' . strtoupper(Str::random(8));

            $bookingId = DB::table('bookings')->insertGetId([
                'schedule_id' => $schedule->id,
                'booking_code' => $bookingCode,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'total_amount' => $total,
                'status' => 'pending_payment',
                'expires_at' => now()->addMinutes(15),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $details = [];

            foreach ($seats as $seat) {
                $details[] = [
                    'booking_id' => $bookingId,
                    'schedule_id' => $schedule->id,
                    'seat_id' => $seat->id,
                    'ticket_price' => $schedule->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('booking_details')->insert($details);

            return (object) [
                'id' => $bookingId,
                'booking_code' => $bookingCode,
            ];
        });

        return redirect()->route('booking.payment', $booking->booking_code);
    }

    // HALAMAN RINGKASAN PEMBAYARAN
    public function payment($code)
    {
        $this->expireBookings();
        $booking = \App\Models\Booking::where('booking_code', $code)->firstOrFail();
        $booking->load(['schedule.film', 'schedule.studio', 'bookingDetails.seat', 'payment']);

        if ($booking->status === 'confirmed') {
            return redirect()->route('booking.ticket', $booking->booking_code);
        }

        return view('payment', [
            'booking' => $booking,
            'schedule' => $booking->schedule,
            'details' => $booking->bookingDetails->map(fn ($detail) => (object) [
                'row' => $detail->seat->row,
                'seat_number' => $detail->seat->seat_number,
                'ticket_price' => $detail->ticket_price,
            ]),
        ]);
    }

    // E-TICKET HANYA UNTUK PEMBAYARAN TERVERIFIKASI
    public function ticket($code)
    {
        $booking = \App\Models\Booking::with([
            'schedule.film', 'schedule.studio', 'bookingDetails.seat', 'payment'
        ])->where('booking_code', $code)->firstOrFail();

        abort_unless($booking->status === 'confirmed' && $booking->payment?->status === 'verified', 403, 'E-ticket tersedia setelah pembayaran diverifikasi.');

        return view('ticket', compact('booking'));
    }

    private function expireBookings(): void
    {
        \App\Models\Booking::where('status', 'pending_payment')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->chunkById(100, function ($bookings) {
                foreach ($bookings as $booking) {
                    DB::transaction(function () use ($booking) {
                        $booking->bookingDetails()->delete();
                        $booking->update(['status' => 'expired']);
                    });
                }
            });
    }

}
