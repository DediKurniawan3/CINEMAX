<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpireBookings extends Command
{
    protected $signature = 'cinemax:expire-bookings';
    protected $description = 'Menutup booking yang melewati batas pembayaran dan melepaskan kursinya';

    public function handle(): int
    {
        $count = 0;
        Booking::where('status', 'pending_payment')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->chunkById(100, function ($bookings) use (&$count) {
                foreach ($bookings as $booking) {
                    DB::transaction(function () use ($booking, &$count) {
                        $booking->bookingDetails()->delete();
                        $booking->update(['status' => 'expired']);
                        $count++;
                    });
                }
            });

        $this->info("{$count} booking kedaluwarsa diproses.");
        return self::SUCCESS;
    }
}
