<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'cinemax:make-admin {email?}';
    protected $description = 'Membuat atau menaikkan akun menjadi administrator CINEMAX';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email admin');
        $name = $this->ask('Nama admin', 'Administrator CINEMAX');
        $password = $this->secret('Password admin (minimal 8 karakter)');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen((string) $password) < 8) {
            $this->error('Email tidak valid atau password kurang dari 8 karakter.');
            return self::FAILURE;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->password = Hash::make($password);
        $user->role = 'admin';
        $user->save();

        $this->info('Akun administrator berhasil disiapkan. Silakan login melalui /admin/login.');
        return self::SUCCESS;
    }
}
