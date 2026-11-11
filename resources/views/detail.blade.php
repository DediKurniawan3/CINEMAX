<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $film->title }} - CINEMAX</title>

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

        a {
            text-decoration: none;
            color: inherit;
        }

        .navbar {
            height: 80px;
            padding: 0 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #111116;
            border-bottom: 1px solid #292932;
        }

        .logo {
            font-size: 27px;
            font-weight: 800;
        }

        .logo span {
            color: #ed1c24;
        }

        .back {
            color: #aaa;
            font-size: 13px;
        }

        .container {
            width: 84%;
            margin: 55px auto;
        }

        .movie-detail {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 45px;
            align-items: center;
        }

        .poster {
            height: 410px;
            border-radius: 14px;
            background: linear-gradient(145deg, #671c25, #171720);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px;
            text-align: center;
            border: 1px solid #333;
        }

        .poster h2 {
            font-size: 34px;
            text-transform: uppercase;
        }

        .tag {
            color: #ed1c24;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 3px;
        }

        .information h1 {
            font-size: 40px;
            margin: 18px 0;
        }

        .meta {
            color: #aaa;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .information h3 {
            margin-bottom: 12px;
        }

        .synopsis {
            color: #aaa;
            line-height: 1.9;
            font-size: 14px;
            max-width: 650px;
        }

        .age {
            display: inline-block;
            border: 1px solid #666;
            padding: 7px 12px;
            border-radius: 5px;
            margin-top: 22px;
            font-size: 12px;
        }

        .schedule-section {
            margin-top: 75px;
        }

        .schedule-section h2 {
            font-size: 25px;
            margin-bottom: 12px;
        }

        .schedule-section h2 span {
            color: #ed1c24;
        }

        .subtitle {
            color: #888;
            font-size: 13px;
            margin-bottom: 30px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .schedule-card {
            background: #15151c;
            border: 1px solid #30303a;
            border-radius: 12px;
            padding: 23px;
        }

        .schedule-card h3 {
            font-size: 17px;
            margin-bottom: 10px;
        }

        .schedule-card p {
            color: #999;
            font-size: 12px;
            margin-bottom: 15px;
        }

        .price {
            color: #ed1c24;
            font-weight: 800;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .time {
            display: inline-block;
            padding: 11px 17px;
            background: #ed1c24;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
        }

        .empty {
            color: #aaa;
            padding: 25px;
            background: #15151c;
            border-radius: 10px;
        }

        footer {
            text-align: center;
            padding: 30px;
            color: #777;
            border-top: 1px solid #292932;
            margin-top: 80px;
            font-size: 12px;
        }

        @media(max-width: 750px) {
            .movie-detail {
                grid-template-columns: 1fr;
            }

            .poster {
                height: 330px;
            }

            .schedule-grid {
                grid-template-columns: 1fr;
            }

            .information h1 {
                font-size: 30px;
            }

            .container {
                width: 90%;
            }
        }


        .poster {
            width: 300px;
            height: 410px;
            overflow: hidden;
            border-radius: 15px;
            background: #17171e;
            flex-shrink: 0;
            padding: 0;
        }

        .poster img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .poster-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

    </style>
</head>

<body>

    <nav class="navbar">

        <a href="{{ route('home') }}" class="logo">
            CINE<span>MAX</span>
        </a>

        <a href="{{ route('home') }}" class="back">
            &larr; Kembali ke Home
        </a>

    </nav>


    <main class="container">

        <!-- DETAIL FILM -->

        <section class="movie-detail">
            
            <div class="poster">
                @if($film->poster)
                    <img
                        src="{{ asset($film->poster) }}"
                        alt="Poster {{ $film->title }}"
                    >
                @else
                    <div class="poster-placeholder">
                        {{ $film->title }}
                    </div>
                @endif
            </div>

            <div class="information">

                <div class="tag">CINEMAX MOVIE DETAIL</div>

                <h1>{{ $film->title }}</h1>

                <div class="meta">
                    {{ $film->genre }}
                    &nbsp; | &nbsp;
                    {{ $film->duration }} Menit
                </div>

                <h3>Sinopsis Film</h3>

                <p class="synopsis">
                    {{ $film->synopsis }}
                </p>

                <span class="age">
                    Rating: {{ $film->age_rating }}
                </span>

            </div>

        </section>


        <!-- JADWAL TAYANG -->

        <section class="schedule-section">

            <h2>Pilih <span>Jadwal Tayang</span></h2>

            <p class="subtitle">
                Pilih studio dan jam tayang film favoritmu.
            </p>

            <div class="schedule-grid">

                @forelse($schedules as $schedule)

                    <div class="schedule-card">

                        <h3>{{ $schedule->studio->name }}</h3>

                        <p>
                            {{ $schedule->studio->studio_type }}
                        </p>

                        <p>
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }}
                        </p>

                        <p>
                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                        </p>

                        <div class="price">
                            Rp {{ number_format($schedule->price, 0, ',', '.') }}
                        </div>

                        <a href="{{ route('booking.seats', $schedule->id) }}" class="time">
                            Pilih Kursi
                        </a>

                    </div>

                @empty

                    <div class="empty">
                        Belum ada jadwal tayang tersedia untuk film ini.
                    </div>

                @endforelse

            </div>

        </section>

    </main>


    <footer>
        &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
    </footer>

</body>
</html>
