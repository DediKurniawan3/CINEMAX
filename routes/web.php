<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/film/{slug}', [HomeController::class, 'show'])->name('film.detail');
Route::get('/jadwal/{id}/kursi', [BookingController::class, 'seats'])->name('booking.seats');
Route::post('/jadwal/{id}/form', [BookingController::class, 'form'])->name('booking.form');
Route::post('/jadwal/{id}/simpan', [BookingController::class, 'store'])->name('booking.store');

// Gunakan booking_code yang acak, bukan ID numerik, untuk akses pelanggan.
Route::get('/pemesanan/{code}', [BookingController::class, 'payment'])->name('booking.payment');
Route::get('/pemesanan/{code}/upload', [PaymentController::class, 'create'])->name('payment.create');
Route::post('/pemesanan/{code}/upload', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/e-ticket/{code}', [BookingController::class, 'ticket'])->name('booking.ticket');

// FITUR TIKET SAYA
Route::get('/tiket-saya', [BookingController::class, 'myTicketForm'])
    ->name('booking.my-ticket');

Route::post('/tiket-saya/cari', [BookingController::class, 'findMyTicket'])
    ->middleware('throttle:5,1')
    ->name('booking.my-ticket.search');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/bukti/{id}', [AdminController::class, 'proof'])->name('proof');
        Route::post('/pembayaran/{id}/verifikasi', [AdminController::class, 'verifyPayment'])->name('payment.verify');
        Route::get('/film', [AdminController::class, 'films'])->name('films');
        Route::post('/film', [AdminController::class, 'storeFilm'])->name('films.store');
        Route::delete('/film/{id}', [AdminController::class, 'deleteFilm'])->name('films.delete');
        Route::get('/jadwal', [AdminController::class, 'schedules'])->name('schedules');
        Route::post('/jadwal', [AdminController::class, 'storeSchedule'])->name('schedules.store');
    });
});
