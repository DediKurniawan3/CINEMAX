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

        /* FILTER TANGGAL */
        .date-filter {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 10px 2px 18px;
            margin: 20px 0;
        }

        .date-button {
            min-width: 75px;
            padding: 12px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
            background: #17171f;
            color: #aaa;
            border: 1px solid #30303a;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.2s;
        }

        .date-button strong {
            font-size: 23px;
            color: white;
        }

        .date-button span,
        .date-button small {
            font-size: 11px;
        }

        .date-button:hover,
        .date-button.active {
            background: #ed1726;
            border-color: #ed1726;
            color: white;
        }

        .date-button.active strong {
            color: white;
        }

        /* SEMBUNYIKAN JADWAL TANGGAL LAIN */
        .schedule-hidden {
            display: none !important;
        }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            .schedule-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .schedule-card {
                padding: 15px;
            }
        }


        /* =================================
        CINEMAX - MIDNIGHT NAVY THEME
        ================================= */

        body {
            background: #0B1424;
            color: #F4F7FC;
        }

        /* NAVBAR */
        .navbar {
            background: #101D30;
            border-bottom: 1px solid #263B57;
        }

        .back {
            color: #B7C7DC;
        }

        /* INFORMASI FILM */
        .information h1 {
            color: #F4F7FC;
        }

        .meta,
        .synopsis {
            color: #A9BAD0;
        }

        .age {
            border-color: #45617F;
            color: #D8E5F5;
        }

        /* POSTER */
        .poster {
            background: linear-gradient(145deg, #245B9E, #101D30);
            border: 1px solid #34577F;
        }

        /* JADWAL TAYANG */
        .schedule-section {
            background: #101D30;
            border: 1px solid #263B57;
            border-radius: 18px;
            padding: 28px;
        }

        .schedule-card {
            background: #172A43;
            border: 1px solid #304967;
            transition: all .3s ease;
        }

        .schedule-card:hover {
            border-color: #4389D8;
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .2);
        }

        .schedule-card p {
            color: #A9BAD0;
        }

        /* FILTER TANGGAL */
        .date-button {
            background: #172A43;
            border-color: #304967;
            color: #C3D2E5;
        }

        .date-button strong {
            color: #FFFFFF;
        }

        .date-button:hover,
        .date-button.active {
            background: #245B9E;
            border-color: #4389D8;
            color: #FFFFFF;
        }

        /* HARGA */
        .price {
            color: #FF5964;
        }

        /* TOMBOL PILIH KURSI */
        .time {
            background: #ED1C24;
            color: #FFFFFF;
            transition: .3s ease;
        }

        .time:hover {
            background: #C81019;
        }

        /* EMPTY STATE */
        .empty {
            background: #172A43;
            color: #B7C7DC;
        }

        /* FOOTER */
        footer {
            background: #101D30;
            border-top: 1px solid #263B57;
            color: #8FA5C0;
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
                Pilih tanggal, studio, dan jam tayang film favoritmu.
            </p>

            @php
                $groupedSchedules = $schedules->groupBy(function ($schedule) {
                    return \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d');
                });

                $firstDate = $groupedSchedules->keys()->first();
            @endphp

            @if($groupedSchedules->isNotEmpty())

                
                    <!-- PILIH TANGGAL -->
                    <div class="date-filter">

                        @foreach($groupedSchedules as $date => $dateSchedules)

                            <button
                                type="button"
                                class="date-button {{ $date === $firstDate ? 'active' : '' }}"
                                data-date="{{ $date }}"
                            >
                                <span>
                                    {{ \Carbon\Carbon::parse($date)->translatedFormat('D') }}
                                </span>

                                <strong>
                                    {{ \Carbon\Carbon::parse($date)->format('d') }}
                                </strong>

                                <small>
                                    {{ \Carbon\Carbon::parse($date)->translatedFormat('M') }}
                                </small>
                            </button>

                        @endforeach

                    </div>


                <!-- DAFTAR JADWAL -->
                <div class="schedule-grid">

                    @foreach($schedules as $schedule)

                        @php
                            $scheduleDate = \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d');
                        @endphp

                        <div
                            class="schedule-card {{ $scheduleDate !== $firstDate ? 'schedule-hidden' : '' }}"
                            data-date="{{ $scheduleDate }}"
                        >

                            <h3>{{ $schedule->studio->name }}</h3>

                            <p>{{ $schedule->studio->studio_type }}</p>

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

                    @endforeach

                </div>

            @else

                <div class="empty">
                    Belum ada jadwal tayang tersedia untuk film ini.
                </div>

            @endif

        </section>


    </main>


    <footer>
        &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const dateButtons = document.querySelectorAll('.date-button');
        const scheduleCards = document.querySelectorAll('.schedule-card');

        dateButtons.forEach(button => {

            button.addEventListener('click', function () {

                const selectedDate = this.dataset.date;

                // Mengubah tanggal aktif
                dateButtons.forEach(item => {
                    item.classList.remove('active');
                });

                this.classList.add('active');

                // Menampilkan jadwal berdasarkan tanggal
                scheduleCards.forEach(card => {

                    if (card.dataset.date === selectedDate) {
                        card.classList.remove('schedule-hidden');
                    } else {
                        card.classList.add('schedule-hidden');
                    }

                });

            });

        });

    });
    </script>
</body>
</html>

