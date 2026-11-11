# CINEMAX — Sistem Pemesanan Tiket Bioskop

Aplikasi pemesanan tiket bioskop berbasis Laravel 10. Proyek ini mencakup katalog film, detail film dan jadwal, pemilihan kursi, formulir pemesan, pembayaran simulasi, verifikasi admin, serta e-ticket digital.

## Kebutuhan
- PHP 8.1 atau lebih baru
- Composer
- MySQL/MariaDB atau database Laravel lain yang didukung
- Node.js/NPM (opsional, bila mengembangkan aset front-end)

## Instalasi
```bash
composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database pada `.env`, lalu jalankan:
```bash
php artisan migrate --seed
php artisan storage:link
```

Buat akun administrator secara interaktif:
```bash
php artisan cinemax:make-admin admin@cinemax.test
```

Masuk ke `http://127.0.0.1:8000/admin/login`, kemudian jalankan aplikasi:
```bash
php artisan serve
```

## Alur pelanggan
1. Pilih film dan jadwal.
2. Pilih kursi yang tersedia.
3. Isi identitas pemesan.
4. Lakukan simulasi transfer dan unggah bukti pembayaran.
5. Admin memverifikasi bukti pembayaran.
6. Setelah terverifikasi, pelanggan dapat membuka e-ticket dari halaman ringkasan booking.

Akses pelanggan menggunakan kode booking acak (bukan ID numerik). E-ticket hanya ditampilkan jika status booking `confirmed` dan pembayaran `verified`.

## Fitur admin
- Dashboard statistik transaksi.
- Verifikasi atau penolakan bukti pembayaran.
- Tambah dan hapus film (film yang memiliki riwayat booking tidak dapat dihapus).
- Tambah jadwal dengan pemeriksaan bentrok studio.
- Bukti transfer disimpan pada storage privat dan hanya dapat dilihat oleh admin yang sudah login.

## Catatan penting
- Nomor rekening pada halaman pembayaran adalah data simulasi. Jangan gunakan untuk transaksi sungguhan.
- QR pada e-ticket berisi kode booking sebagai identitas tiket. Untuk penggunaan operasional nyata, petugas perlu melakukan validasi kode terhadap database; QR ini belum terhubung ke sistem pemindaian gate.
- Masa pembayaran booking adalah 15 menit. Booking yang melewati batas waktu dibersihkan saat halaman pemilihan kursi, pembayaran, atau dashboard admin diakses. Scheduler juga sudah disiapkan setiap menit; jalankan `php artisan schedule:work` saat pengembangan lokal atau konfigurasi Laravel Scheduler di server agar expiry berjalan otomatis.
- Jangan pernah mengunggah `.env`, kredensial database, atau APP_KEY ke GitHub. File `.env` sudah diabaikan oleh `.gitignore`; gunakan `.env.example` sebagai template.
