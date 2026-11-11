<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    // HALAMAN UPLOAD BUKTI PEMBAYARAN
    public function create($code)
    {
        $this->expireBookings();
        $booking = Booking::with(['schedule.film', 'schedule.studio', 'bookingDetails.seat', 'payment'])
            ->where('booking_code', $code)->firstOrFail();
        abort_unless(in_array($booking->status, ['pending_payment', 'waiting_verification']), 403, 'Booking tidak dapat menerima pembayaran.');
        abort_if($booking->status === 'waiting_verification', 403, 'Bukti pembayaran sedang diverifikasi.');
        abort_if(
            $booking->expires_at &&
                \Carbon\Carbon::parse($booking->expires_at)->isPast(),
            410,
            'Masa pembayaran telah berakhir.'
        );

        return view('payment-upload', compact('booking'));
    }

    // SIMPAN BUKTI PEMBAYARAN
    public function store(Request $request, $code)
    {
        $this->expireBookings();
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $booking = Booking::where('booking_code', $code)->firstOrFail();

        if ($booking->status !== 'pending_payment' || ($booking->expires_at && \Carbon\Carbon::parse($booking->expires_at)->isPast())) {
            return back()->withErrors([
                'proof' => 'Pemesanan ini tidak menunggu pembayaran.'
            ]);
        }

        $existingPayment = Payment::where(
            'booking_id',
            $booking->id
        )->first();

        if ($existingPayment && $existingPayment->status === 'verified') {
            return back()->withErrors([
                'proof' => 'Pembayaran sudah diverifikasi.'
            ]);
        }

        $path = $request->file('proof')->store('payment-proofs', 'local');

        if ($existingPayment && $existingPayment->proof_path) {
            Storage::disk('local')->delete(
                $existingPayment->proof_path
            );
        }

        Payment::updateOrCreate(
            ['booking_id' => $booking->id],
            [
                'payment_method' => 'bank_transfer',
                'bank_name' => $request->bank_name,
                'proof_path' => $path,
                'amount' => $booking->total_amount,
                'status' => 'pending',
                'paid_at' => now(),
            ]
        );

        $booking->update(['status' => 'waiting_verification']);

        return redirect()->route('booking.payment', $booking->booking_code)
            ->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }
    private function expireBookings(): void
    {
        Booking::where('status', 'pending_payment')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->chunkById(100, function ($bookings) {
                foreach ($bookings as $booking) {
                    \Illuminate\Support\Facades\DB::transaction(function () use ($booking) {
                        $booking->bookingDetails()->delete();
                        $booking->update(['status' => 'expired']);
                    });
                }
            });
    }
}
