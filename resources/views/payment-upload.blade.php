<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upload Pembayaran - CINEMAX</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0b0b0f;
            color: white;
            font-family: Arial, sans-serif;
        }

        nav {
            background: #141419;
            padding: 22px 8%;
            border-bottom: 1px solid #30303a;
        }

        .logo {
            font-size: 27px;
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .logo span {
            color: #ed1c24;
        }

        .container {
            max-width: 750px;
            margin: 45px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 12px;
        }

        h1 span {
            color: #ed1c24;
        }

        .subtitle {
            color: #999;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .card {
            background: #17171e;
            border: 1px solid #30303a;
            padding: 28px;
            border-radius: 12px;
            margin-bottom: 22px;
        }

        .card h2 {
            font-size: 19px;
            margin-bottom: 22px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 14px;
            color: #aaa;
        }

        .info strong {
            color: white;
            text-align: right;
        }

        .total {
            border-top: 1px solid #333;
            padding-top: 20px;
            margin-top: 20px;
        }

        .total strong {
            color: #ed1c24;
            font-size: 23px;
        }

        .bank {
            background: #22222b;
            border: 1px solid #383843;
            padding: 18px;
            border-radius: 8px;
            margin-bottom: 12px;
        }

        .bank h3 {
            margin-bottom: 8px;
        }

        .bank p {
            color: #aaa;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .account {
            font-size: 19px;
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
        }

        select, input {
            width: 100%;
            padding: 14px;
            background: #101015;
            border: 1px solid #383843;
            border-radius: 7px;
            color: white;
        }

        input[type=file] {
            padding: 12px;
        }

        .hint {
            color: #888;
            font-size: 12px;
            margin-top: 8px;
        }

        .error {
            color: #ff6868;
            font-size: 12px;
            margin-top: 8px;
        }

        .submit {
            width: 100%;
            background: #ed1c24;
            border: none;
            padding: 16px;
            border-radius: 7px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .submit:hover {
            background: #c81019;
        }

        footer {
            text-align: center;
            color: #666;
            padding: 30px;
        }
    </style>
</head>

<body>

<nav>
    <a href="{{ route('home') }}" class="logo">
        CINE<span>MAX</span>
    </a>
</nav>

<div class="container">

    <h1>Upload Bukti <span>Transfer</span></h1>

    <p class="subtitle">
        Silakan lakukan transfer dan unggah bukti pembayaran.
    </p>

    <div class="card">

        <h2>Informasi Pemesanan</h2>

        <div class="info">
            <span>Kode Booking</span>
            <strong>{{ $booking->booking_code }}</strong>
        </div>

        <div class="info">
            <span>Nama Pemesan</span>
            <strong>{{ $booking->customer_name }}</strong>
        </div>

        <div class="info">
            <span>Film</span>
            <strong>{{ $booking->schedule->film->title }}</strong>
        </div>

        <div class="info">
            <span>Studio</span>
            <strong>{{ $booking->schedule->studio->name }}</strong>
        </div>

        <div class="info total">
            <span>Total Transfer</span>
            <strong>
                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
            </strong>
        </div>

    </div>

    <div class="card">

        <h2>Rekening Tujuan</h2>

        <div class="bank">
            <h3>BCA</h3>
            <p>Atas Nama: CINEMAX</p>
            <div class="account">1234567890</div>
        </div>

        <div class="bank">
            <h3>BRI</h3>
            <p>Atas Nama: CINEMAX</p>
            <div class="account">1234567890</div>
        </div>

        <div class="bank">
            <h3>BNI</h3>
            <p>Atas Nama: CINEMAX</p>
            <div class="account">1234567890</div>
        </div>

        <div class="bank">
            <h3>Mandiri</h3>
            <p>Atas Nama: CINEMAX</p>
            <div class="account">1234567890</div>
        </div>

        <p class="hint">
            Nomor rekening hanya contoh untuk simulasi tugas kuliah.
        </p>

    </div>

    <form
        action="{{ route('payment.store', $booking->booking_code) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        <div class="card">

            <h2>Konfirmasi Pembayaran</h2>

            <div class="form-group">

                <label>Pilih Bank Pengirim</label>

                <select name="bank_name" required>
                    <option value="">-- Pilih Bank --</option>
                    <option value="BCA">BCA</option>
                    <option value="BRI">BRI</option>
                    <option value="BNI">BNI</option>
                    <option value="Mandiri">Mandiri</option>
                </select>

                @error('bank_name')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            <div class="form-group">

                <label>Upload Bukti Transfer</label>

                <input
                    type="file"
                    name="proof"
                    accept="image/png,image/jpeg,image/webp"
                    required
                >

                <p class="hint">
                    Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                </p>

                @error('proof')
                    <p class="error">{{ $message }}</p>
                @enderror

            </div>

            <button type="submit" class="submit">
                Kirim Bukti Pembayaran
            </button>

        </div>

    </form>

</div>

<footer>
    &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
</footer>

</body>
</html>
