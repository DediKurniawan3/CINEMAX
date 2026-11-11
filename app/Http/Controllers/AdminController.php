<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Film;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials) && Auth::user()->role === 'admin') {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        Auth::logout();
        return back()->withErrors(['email' => 'Email atau kata sandi admin tidak valid.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $this->expireBookings();
        $stats = [
            'films' => Film::count(),
            'bookings' => Booking::count(),
            'waiting' => Booking::where('status', 'waiting_verification')->count(),
            'revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
        ];
        $bookings = Booking::with(['schedule.film', 'payment'])
            ->latest()->take(30)->get();

        return view('admin.dashboard', compact('stats', 'bookings'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $data = $request->validate(['decision' => ['required', Rule::in(['verify', 'reject'])]]);
        $booking = Booking::with('payment')->findOrFail($id);

        if ($booking->status !== 'waiting_verification' || !$booking->payment) {
            return back()->with('error', 'Booking tidak berada dalam antrean verifikasi.');
        }

        DB::transaction(function () use ($booking, $data) {
            if ($data['decision'] === 'verify') {
                $booking->payment->update(['status' => 'verified']);
                $booking->update(['status' => 'confirmed']);
            } else {
                $booking->payment->update(['status' => 'rejected']);
                $booking->update([
                    'status' => 'pending_payment',
                    'expires_at' => now()->addMinutes(15),
                ]);
            }
        });

        return back()->with('success', $data['decision'] === 'verify'
            ? 'Pembayaran diverifikasi. E-ticket sudah dapat diakses pelanggan.'
            : 'Pembayaran ditolak. Pelanggan dapat mengunggah ulang bukti selama masa booking aktif.');
    }

    public function proof($id)
    {
        $payment = Payment::findOrFail($id);
        abort_unless($payment->proof_path && \Illuminate\Support\Facades\Storage::disk('local')->exists($payment->proof_path), 404);
        return \Illuminate\Support\Facades\Storage::disk('local')->response($payment->proof_path);
    }

    public function films()
    {
        return view('admin.films', ['films' => Film::latest()->get()]);
    }

    public function storeFilm(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'genre' => ['required', 'string', 'max:100'],
            'duration' => ['required', 'integer', 'min:1', 'max:500'],
            'age_rating' => ['nullable', 'string', 'max:10'],
            'release_date' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['coming_soon', 'now_showing', 'ended'])],
            'synopsis' => ['nullable', 'string', 'max:5000'],
        ]);
        $base = Str::slug($data['title']);
        $slug = $base;
        $i = 1;
        while (Film::where('slug', $slug)->exists()) $slug = $base.'-'.$i++;
        $data['slug'] = $slug;
        Film::create($data);
        return back()->with('success', 'Film berhasil ditambahkan.');
    }

    public function deleteFilm($id)
    {
        $film = Film::findOrFail($id);
        if ($film->schedules()->exists()) {
            return back()->with('error', 'Film sudah memiliki jadwal tayang dan tidak dapat dihapus. Ubah status menjadi ended.');
        }
        $film->delete();
        return back()->with('success', 'Film berhasil dihapus.');
    }

    public function schedules()
    {
        return view('admin.schedules', [
            'schedules' => Schedule::with(['film', 'studio'])->latest('start_time')->get(),
            'films' => Film::where('status', '!=', 'ended')->orderBy('title')->get(),
            'studios' => Studio::orderBy('name')->get(),
        ]);
    }

    public function storeSchedule(Request $request)
    {
        $data = $request->validate([
            'film_id' => ['required', 'exists:films,id'],
            'studio_id' => ['required', 'exists:studios,id'],
            'start_time' => ['required', 'date', 'after:now'],
            'price' => ['required', 'numeric', 'min:1', 'max:10000000'],
        ]);
        $film = Film::findOrFail($data['film_id']);
        if ($film->status === 'ended') {
            return back()->withErrors(['film_id' => 'Film yang sudah selesai tayang tidak dapat dijadwalkan.'])->withInput();
        }
        $start = \Illuminate\Support\Carbon::parse($data['start_time']);
        $end = $start->copy()->addMinutes($film->duration + 15);
        $overlap = Schedule::where('studio_id', $data['studio_id'])
            ->where('status', 'active')
            ->where('start_time', '<', $end)
            ->where('end_time', '>', $start)->exists();
        if ($overlap) return back()->withErrors(['start_time' => 'Studio sudah memiliki jadwal pada rentang waktu tersebut.'])->withInput();
        Schedule::create([
            'film_id' => $film->id,
            'studio_id' => $data['studio_id'],
            'start_time' => $start,
            'end_time' => $end,
            'price' => $data['price'],
            'status' => 'active',
        ]);
        return back()->with('success', 'Jadwal tayang berhasil ditambahkan.');
    }

    private function expireBookings(): void
    {
        Booking::where('status', 'pending_payment')
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
