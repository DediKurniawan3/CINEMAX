<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - CINEMAX</title>

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
            max-width: 850px;
            margin: 45px auto;
            padding: 0 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        h1 span {
            color: #ed1c24;
        }

        .subtitle {
            color: #999;
            margin-bottom: 30px;
        }

        .card {
            background: #17171e;
            border: 1px solid #30303a;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 22px;
        }

        h2 {
            font-size: 19px;
            margin-bottom: 20px;
        }

        .info {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 15px;
            color: #aaa;
            font-size: 14px;
        }

        .info strong {
            color: white;
            text-align: right;
        }

        .booking-code {
            color: #ed1c24 !important;
        }

        .bank {
            background: #22222b;
            border: 1px solid #383843;
            padding: 17px;
            border-radius: 9px;
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
            font-size: 17px;
            color: white;
            font-weight: bold;
        }

        .total {
            border-top: 1px solid #393943;
            padding-top: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }

        .total strong {
            font-size: 23px;
            color: #ed1c24;
        }

        .notice{background:#163a2b;color:#a7f3d0;padding:14px 18px;border-radius:8px;margin-bottom:20px}
        .status {
            display: inline-block;
            background: #443516;
            color: #ffc857;
            padding: 8px 13px;
            border-radius: 5px;
            font-size: 12px;
        }

        footer {
            text-align: center;
            padding: 30px;
            color: #666;
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

    @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
    <h1>Pembayaran <span>Tiket</span></h1>

    <p class="subtitle">
        Selesaikan pembayaran untuk mengamankan tiket bioskopmu.
    </p>

    <div class="card">

        <h2>Ringkasan Pemesanan</h2>

        <div class="info">
            <span>Kode Booking</span>
            <strong class="booking-code">
                {{ $booking->booking_code }}
            </strong>
        </div>

        <div class="info">
            <span>Nama Pemesan</span>
            <strong>{{ $booking->customer_name }}</strong>
        </div>

        <div class="info">
            <span>Film</span>
            <strong>{{ $schedule->film->title }}</strong>
        </div>

        <div class="info">
            <span>Studio</span>
            <strong>{{ $schedule->studio->name }}</strong>
        </div>

        <div class="info">
            <span>Kursi</span>
            <strong>
                @foreach($details as $detail)
                    {{ $detail->row }}{{ $detail->seat_number }}@if(!$loop->last), @endif
                @endforeach
            </strong>
        </div>

        <div class="total">
            <span>Total Pembayaran</span>

            <strong>
                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
            </strong>
        </div>

        <br>

        <span class="status">{{ strtoupper(str_replace('_', ' ', $booking->status)) }}</span>        
        @if($booking->status === 'pending_payment' && $booking->expires_at)
            <p style="color:#aaa;font-size:12px;margin-top:12px">
                Batas pembayaran: {{ \Carbon\Carbon::parse($booking->expires_at)->format('d/m/Y H:i') }}
            </p>
        @endif

        @if($booking->status === 'waiting_verification')<p style="color:#ffc857;margin-top:14px">Bukti pembayaran telah diterima dan sedang diperiksa admin.</p>@endif
        @if($booking->status === 'expired')<p style="color:#ff7777;margin-top:14px">Masa pembayaran telah berakhir. Silakan buat pemesanan baru.</p>@endif

    </div>

    <div class="card">

        <h2>Transfer Bank</h2>

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

        <p style="color:#999;font-size:12px;margin-top:15px;">
            Nomor rekening di atas hanya contoh untuk pengembangan.
            Jangan gunakan untuk transfer sungguhan.
        </p>

    </div>

    @if($booking->status === 'pending_payment')
    <a href="{{ route('payment.create', $booking->booking_code) }}"
    style="
        display:block;
        text-align:center;
        padding:16px;
        background:#ed1c24;
        color:white;
        text-decoration:none;
        border-radius:7px;
        font-weight:bold;
        margin-top:20px;
    ">
        Upload Bukti Transfer →
    </a>
    @endif

</div>

<footer>
    &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
</footer>

</body>
</html>
