
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya | CINEMAX</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: #0B1424;
            color: #F4F7FC;
            font-family: Arial, sans-serif;
        }

        .navbar {
            padding: 22px 7%;
            background: #101D30;
            border-bottom: 1px solid #263B57;
        }

        .logo {
            font-size: 25px;
            font-weight: 900;
            letter-spacing: 2px;
            color: white;
            text-decoration: none;
        }

        .logo span {
            color: #ED1C24;
        }

        .container {
            width: min(480px, 92%);
            margin: 75px auto;
        }

        .ticket-card {
            background: #14243A;
            border: 1px solid #304967;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 15px 40px rgba(0,0,0,.2);
        }

        .icon {
            width: 58px;
            height: 58px;
            background: #245B9E;
            border-radius: 14px;
            display: grid;
            place-items: center;
            font-size: 28px;
            margin-bottom: 22px;
        }

        h1 {
            font-size: 27px;
            margin: 0 0 10px;
        }

        .subtitle {
            color: #A9BAD0;
            font-size: 14px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        input {
            width: 100%;
            padding: 14px;
            background: #0B1424;
            border: 1px solid #304967;
            border-radius: 9px;
            color: white;
            font-size: 14px;
            outline: none;
            margin-bottom: 20px;
        }

        input:focus {
            border-color: #4389D8;
        }

        .error {
            color: #ff7777;
            font-size: 12px;
            margin-top: -13px;
            margin-bottom: 15px;
        }

        .submit-btn {
            width: 100%;
            border: none;
            border-radius: 9px;
            padding: 15px;
            background: #ED1C24;
            color: white;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: .3s;
        }

        .submit-btn:hover {
            background: #C81019;
            transform: translateY(-2px);
        }

        .back {
            display: block;
            text-align: center;
            margin-top: 22px;
            color: #A9BAD0;
            text-decoration: none;
            font-size: 13px;
        }

        .back:hover {
            color: white;
        }

        .notice {
            color: #91A9C5;
            font-size: 11px;
            text-align: center;
            margin-top: 22px;
            line-height: 1.6;
        }

        @media(max-width: 500px) {
            .ticket-card {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            CINE<span>MAX</span>
        </a>
    </nav>

    <main class="container">

        <div class="ticket-card">

            <div class="icon">🎟</div>

            <h1>Tiket Saya</h1>

            <p class="subtitle">
                Temukan kembali pesanan tiket bioskopmu.
                Masukkan kode booking dan email yang digunakan
                saat melakukan pemesanan.
            </p>

            <form
                action="{{ route('booking.my-ticket.search') }}"
                method="POST"
            >
                @csrf

                <label for="booking_code">Kode Booking</label>

                <input
                    type="text"
                    id="booking_code"
                    name="booking_code"
                    placeholder="Contoh: CMX-AB12CD34"
                    value="{{ old('booking_code') }}"
                    maxlength="20"
                    required
                >

                @error('booking_code')
                    <div class="error">{{ $message }}</div>
                @enderror

                <label for="customer_email">Email Pemesanan</label>

                <input
                    type="email"
                    id="customer_email"
                    name="customer_email"
                    placeholder="Masukkan email pemesanan"
                    value="{{ old('customer_email') }}"
                    required
                >

                @error('customer_email')
                    <div class="error">{{ $message }}</div>
                @enderror

                @error('booking')
                    <div class="error">{{ $message }}</div>
                @enderror

                <button type="submit" class="submit-btn">
                    CARI TIKET
                </button>

            </form>

            <a href="{{ route('home') }}" class="back">
                ← Kembali ke Beranda
            </a>

            <p class="notice">
                Pastikan kode booking dan email sesuai dengan
                data yang digunakan saat pemesanan.
            </p>

        </div>

    </main>

</body>
</html>
