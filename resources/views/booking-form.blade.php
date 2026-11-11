<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Pemesan - CINEMAX</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0b0b0f;
            color: white;
            font-family: Inter, sans-serif;
        }

        .navbar {
            padding: 22px 8%;
            background: #111116;
            border-bottom: 1px solid #292932;
        }

        .logo {
            font-size: 26px;
            font-weight: 800;
            color: white;
            text-decoration: none;
        }

        .logo span {
            color: #ed1c24;
        }

        .container {
            max-width: 850px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .heading {
            margin-bottom: 30px;
        }

        .heading h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .heading h1 span {
            color: #ed1c24;
        }

        .heading p {
            color: #999;
            font-size: 13px;
        }

        .card {
            background: #17171e;
            border: 1px solid #30303a;
            padding: 30px;
            border-radius: 13px;
            margin-bottom: 25px;
        }

        .card h2 {
            font-size: 19px;
            margin-bottom: 22px;
        }

        .movie-info {
            color: #aaa;
            line-height: 2;
            font-size: 13px;
        }

        .movie-info strong {
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-bottom: 9px;
        }

        input {
            width: 100%;
            padding: 14px;
            background: #101015;
            border: 1px solid #363640;
            border-radius: 7px;
            color: white;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #ed1c24;
        }

        .error {
            color: #ff6868;
            font-size: 12px;
            margin-top: 7px;
        }

        .seats {
            color: #ed1c24;
            font-weight: 700;
            margin-top: 12px;
        }

        .total {
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #333;
            padding-top: 20px;
            margin-top: 20px;
        }

        .total strong {
            color: #ed1c24;
            font-size: 22px;
        }

        .submit {
            width: 100%;
            background: #ed1c24;
            color: white;
            border: none;
            padding: 16px;
            border-radius: 7px;
            font-weight: 700;
            cursor: pointer;
            font-size: 14px;
        }

        .submit:hover {
            background: #c81019;
        }

        footer {
            text-align: center;
            color: #666;
            padding: 30px;
            font-size: 12px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">
        CINE<span>MAX</span>
    </a>
</nav>

<div class="container">

    <div class="heading">
        <h1>Data <span>Pemesan</span></h1>
        <p>Lengkapi informasi berikut untuk melanjutkan pemesanan tiket.</p>
    </div>

    <div class="card">

        <h2>Informasi Film</h2>

        <div class="movie-info">
            Film: <strong>{{ $schedule->film->title }}</strong>
            <br>

            Studio: <strong>{{ $schedule->studio->name }}</strong>
            <br>

            Tanggal:
            <strong>
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }}
            </strong>
            <br>

            Jam:
            <strong>
                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
            </strong>
        </div>

        <p class="seats">
            Kursi:
            @foreach($seats as $seat)
                {{ $seat->row }}{{ $seat->seat_number }}@if(!$loop->last), @endif
            @endforeach
        </p>

    </div>


    <form action="{{ route('booking.store', $schedule->id) }}"
          method="POST">

        @csrf

        @foreach($seatIds as $seatId)
            <input type="hidden" name="seat_ids[]" value="{{ $seatId }}">
        @endforeach

        <div class="card">

            <h2>Identitas Pemesan</h2>

            <div class="form-group">
                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="customer_name"
                    value="{{ old('customer_name') }}"
                    placeholder="Masukkan nama lengkap"
                    required
                >

                @error('customer_name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Email</label>

                <input
                    type="email"
                    name="customer_email"
                    value="{{ old('customer_email') }}"
                    placeholder="contoh@email.com"
                    required
                >

                @error('customer_email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>Nomor HP</label>

                <input
                    type="tel"
                    name="customer_phone"
                    value="{{ old('customer_phone') }}"
                    placeholder="08xxxxxxxxxx"
                    required
                >

                @error('customer_phone')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

        </div>


        <div class="card">

            <h2>Ringkasan Pembayaran</h2>

            <div class="movie-info">
                Jumlah tiket: <strong>{{ $seats->count() }}</strong>
            </div>

            <div class="total">
                <span>Total Harga</span>

                <strong>
                    Rp {{ number_format($total, 0, ',', '.') }}
                </strong>
            </div>

        </div>

        <button type="submit" class="submit">
            Lanjutkan ke Pembayaran →
        </button>

    </form>

</div>

<footer>
    &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
</footer>

</body>
</html>
