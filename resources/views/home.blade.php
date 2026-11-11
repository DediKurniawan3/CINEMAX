<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CINEMAX - Experience The Movies</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0b0b0f;
            color: #fff;
            font-family: 'Inter', sans-serif;
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
            border-bottom: 1px solid #24242c;
        }

        .logo {
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 2px;
        }

        .logo span {
            color: #ed1c24;
        }

        .nav-links {
            display: flex;
            gap: 35px;
            color: #aaa;
            font-size: 14px;
        }

        .nav-links a:hover {
            color: #ed1c24;
        }

        .nav-button {
            background: #ed1c24;
            padding: 12px 23px;
            border-radius: 7px;
            font-weight: 700;
            font-size: 13px;
        }

        .hero {
            margin: 35px auto;
            width: 84%;
            min-height: 390px;
            border-radius: 18px;
            padding: 65px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(90deg, #15151b 25%, rgba(15,15,20,.75) 65%, rgba(15,15,20,.3)),
                linear-gradient(135deg, #64151a, #17171f 65%, #32151b);
            border: 1px solid #292932;
            overflow: hidden;
        }

        .hero-content {
            max-width: 560px;
        }

        .tag {
            color: #ff454b;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 3px;
        }

        .hero h1 {
            font-size: 48px;
            margin: 18px 0;
            line-height: 1.15;
        }

        .hero p {
            color: #b5b5c0;
            line-height: 1.8;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .primary-button {
            display: inline-block;
            background: #ed1c24;
            padding: 14px 25px;
            border-radius: 7px;
            font-weight: 700;
            font-size: 13px;
        }

        .container {
            width: 84%;
            margin: 60px auto;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .section-heading h2 {
            font-size: 24px;
        }

        .section-heading h2 span {
            color: #ed1c24;
        }

        .section-heading p {
            color: #888;
            font-size: 12px;
            margin-top: 8px;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 25px;
        }

        .movie-card {
            background: #15151c;
            border: 1px solid #282832;
            border-radius: 12px;
            overflow: hidden;
            transition: .3s;
        }

        .movie-card:hover {
            transform: translateY(-7px);
            border-color: #ed1c24;
        }

        
        .poster {
            height: 430px;
            padding: 0;
            position: relative;
            overflow: hidden;
            background: #15151c;
        }

        .poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            position: absolute;
            inset: 0;
        }

        .poster::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.85),
                transparent 65%
            );
        }

        .poster-label {
            z-index: 2;
        }

        .poster h3 {
            position: absolute;
            z-index: 2;
            bottom: 20px;
            left: 20px;
            right: 20px;
            font-size: 23px;
            text-transform: uppercase;
        }


        .movie-info {
            padding: 20px;
        }

        .movie-info p {
            color: #999;
            font-size: 12px;
            margin: 9px 0 16px;
        }

        .movie-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .age {
            border: 1px solid #555;
            padding: 5px 8px;
            border-radius: 4px;
            color: #ccc;
            font-size: 11px;
        }

        .book-button {
            background: #ed1c24;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 700;
        }

        .empty {
            color: #888;
            padding: 35px;
            text-align: center;
            border: 1px dashed #38383f;
            border-radius: 10px;
            grid-column: 1 / -1;
        }

        footer {
            background: #111116;
            border-top: 1px solid #282832;
            padding: 35px 8%;
            text-align: center;
            color: #777;
            font-size: 12px;
        }

        footer strong {
            color: #ed1c24;
        }

        @media(max-width: 800px) {
            .navbar {
                padding: 0 5%;
            }

            .nav-links {
                display: none;
            }

            .hero {
                width: 90%;
                padding: 35px 25px;
                min-height: 330px;
            }

            .hero h1 {
                font-size: 34px;
            }

            .container {
                width: 90%;
            }

            .movie-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width: 520px) {
            .movie-grid {
                grid-template-columns: 1fr;
            }

            .logo {
                font-size: 21px;
            }

            .nav-button {
                padding: 10px;
            }
        }

        .admin-nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #b91c1c;
            color: #fff !important;
            border: 1px solid #dc2626;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            transition: all .3s ease;
        }

        .admin-nav-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 5px 18px rgba(220, 38, 38, .3);
        }

    </style>
</head>

<body>

    @if (session('success'))
        <div style="
            background: #14532d;
            color: white;
            padding: 15px;
            margin: 20px auto;
            max-width: 1100px;
            border-radius: 8px;
            text-align: center;
        ">
            {{ session('success') }}
        </div>
    @endif

    <!-- NAVBAR -->
    <nav class="navbar">

        <a href="{{ route('home') }}" class="logo">
            CINE<span>MAX</span>
        </a>

        <div class="nav-links">
            <a href="{{ route('home') }}">Home</a>
            <a href="#now-showing">Now Showing</a>
            <a href="#coming-soon">Coming Soon</a>
        </div>


        <a href="{{ url('/admin/login') }}" class="admin-nav-btn">
            <span>♙</span> ADMIN
        </a>
        <a href="#now-showing" class="nav-button">
            Pesan Tiket
        </a>

    </nav>


    <!-- HERO -->
    <section class="hero">

        <div class="hero-content">

            <div class="tag">WELCOME TO CINEMAX</div>

            <h1>
                Experience<br>
                The Magic of Movies.
            </h1>

            <p>
                Nikmati pengalaman menonton film terbaik
                dengan kualitas layar dan audio yang luar biasa.
                Pesan tiket bioskop favoritmu dengan mudah
                hanya melalui CINEMAX.
            </p>

            <a href="#now-showing" class="primary-button">
                Explore Movies &rarr;
            </a>

        </div>

    </section>


    <!-- NOW SHOWING -->
    <section class="container" id="now-showing">

        <div class="section-heading">
            <div>
                <h2>Now <span>Showing</span></h2>
                <p>Film yang sedang tayang di CINEMAX</p>
            </div>
        </div>

        <div class="movie-grid">

            @forelse($nowShowing as $film)

                <div class="movie-card">

                    
                    <div class="poster">

                        @if($film->poster)
                            <img
                                src="{{ asset($film->poster) }}"
                                alt="Poster {{ $film->title }}"
                                loading="lazy"
                            >
                        @endif

                        <span class="poster-label">
                            NOW SHOWING
                        </span>

                        <h3>{{ $film->title }}</h3>

                    </div>


                    <div class="movie-info">

                        <h3>{{ $film->title }}</h3>

                        <p>
                            {{ $film->genre }}
                            &bull;
                            {{ $film->duration }} menit
                        </p>

                        <div class="movie-bottom">

                            <span class="age">
                                {{ $film->age_rating }}
                            </span>

                            <a href="{{ route('film.detail', $film->slug) }}"
                            class="book-button">
                                Pilih Film
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="empty">
                    Belum ada film yang tersedia.
                </div>

            @endforelse

        </div>

    </section>


    <!-- COMING SOON -->
    <section class="container" id="coming-soon">

        <div class="section-heading">
            <div>
                <h2>Coming <span>Soon</span></h2>
                <p>Film yang akan segera hadir di CINEMAX</p>
            </div>
        </div>

        <div class="movie-grid">

            @forelse($comingSoon as $film)

                <div class="movie-card">

                    <div class="poster">

                        <span class="poster-label">
                            COMING SOON
                        </span>

                        <h3>{{ $film->title }}</h3>

                    </div>

                    <div class="movie-info">

                        <h3>{{ $film->title }}</h3>

                        <p>
                            {{ $film->genre }}
                            &bull;
                            {{ $film->duration }} menit
                        </p>

                        <div class="movie-bottom">

                            <span class="age">
                                {{ $film->age_rating }}
                            </span>

                            <span style="color:#ed1c24;font-size:11px;">
                                Segera Hadir
                            </span>

                        </div>

                    </div>

                </div>

            @empty

                <div class="empty">
                    Belum ada film mendatang.
                </div>

            @endforelse

        </div>

    </section>


    <!-- FOOTER -->
    <footer>

        <h2 style="margin-bottom:12px;">
            CINE<strong>MAX</strong>
        </h2>

        <p>
            Your Movie Experience Starts Here.
        </p>

        <p style="margin-top:15px;">
            &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
        </p>

    </footer>

</body>
</html>
