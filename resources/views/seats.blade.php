<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pilih Kursi - CINEMAX</title>

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
            background: #111116;
            padding: 22px 8%;
            border-bottom: 1px solid #292932;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 26px;
            font-weight: 800;
            text-decoration: none;
            color: white;
        }

        .logo span {
            color: #ed1c24;
        }

        .back {
            color: #aaa;
            text-decoration: none;
            font-size: 13px;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .heading {
            text-align: center;
            margin-bottom: 35px;
        }

        .heading h1 {
            font-size: 30px;
            margin-bottom: 12px;
        }

        .heading h1 span {
            color: #ed1c24;
        }

        .heading p {
            color: #999;
            font-size: 13px;
        }

        .movie-info {
            background: #17171e;
            border: 1px solid #30303a;
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 40px;
        }

        .movie-info h2 {
            font-size: 21px;
            margin-bottom: 10px;
        }

        .movie-info p {
            color: #aaa;
            font-size: 13px;
            line-height: 1.8;
        }

        .screen {
            width: 75%;
            margin: 0 auto 65px;
            text-align: center;
        }

        .screen-line {
            height: 5px;
            background: #ed1c24;
            border-radius: 50%;
            box-shadow: 0 8px 25px rgba(237,28,36,.4);
            margin-bottom: 18px;
        }

        .screen p {
            color: #777;
            font-size: 12px;
            letter-spacing: 5px;
        }

        .seat-map {
            background: #14141b;
            border: 1px solid #30303a;
            padding: 35px 15px;
            border-radius: 15px;
            overflow-x: auto;
        }

        .seat-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            margin-bottom: 13px;
            min-width: 380px;
        }

        .row-label {
            color: #888;
            width: 22px;
            font-size: 13px;
        }

        .seat {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px 8px 4px 4px;
            background: #454550;
            color: white;
            font-size: 10px;
            cursor: pointer;
            transition: .2s;
        }

        .seat:hover:not(:disabled) {
            background: #777;
            transform: translateY(-3px);
        }

        .seat.selected {
            background: #ed1c24;
            box-shadow: 0 0 12px rgba(237,28,36,.4);
        }

        .seat.booked {
            background: #25252c;
            color: #555;
            cursor: not-allowed;
        }

        .legend {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 25px;
            margin-top: 30px;
            color: #aaa;
            font-size: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-box {
            width: 17px;
            height: 17px;
            border-radius: 4px;
            background: #454550;
        }

        .legend-box.red {
            background: #ed1c24;
        }

        .legend-box.dark {
            background: #25252c;
        }

        .summary {
            margin-top: 35px;
            background: #17171e;
            border: 1px solid #30303a;
            padding: 25px;
            border-radius: 12px;
        }

        .summary h3 {
            margin-bottom: 20px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            color: #aaa;
            font-size: 14px;
        }

        .summary-row strong {
            color: white;
        }

        .total {
            border-top: 1px solid #333;
            padding-top: 18px;
            margin-top: 10px;
        }

        .total strong {
            color: #ed1c24;
            font-size: 22px;
        }

        .continue-btn {
            width: 100%;
            background: #ed1c24;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 7px;
            font-weight: 700;
            cursor: pointer;
            margin-top: 20px;
        }

        .continue-btn:hover {
            background: #c81019;
        }

        footer {
            text-align: center;
            color: #666;
            padding: 35px;
            margin-top: 60px;
            border-top: 1px solid #292932;
            font-size: 12px;
        }

        @media(max-width: 600px) {
            .heading h1 {
                font-size: 24px;
            }

            .seat {
                width: 29px;
                height: 31px;
            }

            .seat-row {
                gap: 5px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="logo">
        CINE<span>MAX</span>
    </a>

    <a href="{{ route('film.detail', $schedule->film->slug) }}" class="back">
        &larr; Kembali
    </a>
</nav>

<div class="container">

    <div class="heading">
        <h1>Pilih <span>Kursi Favoritmu</span></h1>
        <p>Pilih tempat duduk terbaik untuk pengalaman menontonmu.</p>
    </div>

    <div class="movie-info">
        <h2>{{ $schedule->film->title }}</h2>

        <p>
            Studio: {{ $schedule->studio->name }}
            <br>
            Tanggal:
            {{ \Carbon\Carbon::parse($schedule->start_time)->format('d M Y') }}
            <br>
            Jam:
            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
            <br>
            Harga:
            Rp {{ number_format($schedule->price, 0, ',', '.') }}
        </p>
    </div>

    <div class="screen">
        <div class="screen-line"></div>
        <p>LAYAR BIOSKOP</p>
    </div>

    <div class="seat-map">

        @foreach($seats->groupBy('row') as $row => $rowSeats)

            <div class="seat-row">

                <span class="row-label">{{ $row }}</span>

                @foreach($rowSeats as $seat)

                    @php
                        $isBooked = in_array(
                            $seat->id,
                            $bookedSeatIds
                        );
                    @endphp

                    <button
                        type="button"
                        class="seat {{ $isBooked ? 'booked' : '' }}"
                        data-id="{{ $seat->id }}"
                        data-number="{{ $seat->row }}{{ $seat->seat_number }}"
                        data-booked="{{ $isBooked ? '1' : '0' }}"
                        {{ $isBooked ? 'disabled' : '' }}
                    >
                        {{ $seat->seat_number }}
                    </button>

                @endforeach

                <span class="row-label">{{ $row }}</span>

            </div>

        @endforeach

    </div>

    <div class="legend">

        <div class="legend-item">
            <span class="legend-box"></span>
            Tersedia
        </div>

        <div class="legend-item">
            <span class="legend-box red"></span>
            Dipilih
        </div>

        <div class="legend-item">
            <span class="legend-box dark"></span>
            Terisi
        </div>

    </div>

    <div class="summary">

        <h3>Ringkasan Pemesanan</h3>

        <div class="summary-row">
            <span>Kursi dipilih</span>
            <strong id="selectedSeats">Belum ada</strong>
        </div>

        <div class="summary-row">
            <span>Jumlah tiket</span>
            <strong id="seatCount">0</strong>
        </div>

        <div class="summary-row total">
            <span>Total pembayaran</span>
            <strong id="totalPrice">
                Rp 0
            </strong>
        </div>

        <button class="continue-btn" onclick="continueBooking()">
            Lanjutkan Pemesanan
        </button>

    </div>

</div>

<footer>
    &copy; {{ date('Y') }} CINEMAX. All Rights Reserved.
</footer>

<script>

    const price = {{ (float) $schedule->price }};

    let selectedSeats = [];

    const buttons = document.querySelectorAll('.seat:not(.booked)');

    buttons.forEach(button => {

        button.addEventListener('click', function() {

            const id = this.dataset.id;
            const number = this.dataset.number;

            const existing = selectedSeats.find(
                seat => seat.id === id
            );

            if (existing) {

                selectedSeats = selectedSeats.filter(
                    seat => seat.id !== id
                );

                this.classList.remove('selected');

            } else {

                selectedSeats.push({
                    id: id,
                    number: number
                });

                this.classList.add('selected');

            }

            updateSummary();

        });

    });


    function updateSummary() {

        const numbers = selectedSeats.map(
            seat => seat.number
        );

        document.getElementById('selectedSeats').textContent =
            numbers.length ? numbers.join(', ') : 'Belum ada';

        document.getElementById('seatCount').textContent =
            selectedSeats.length;

        const total = selectedSeats.length * price;

        document.getElementById('totalPrice').textContent =
            'Rp ' + total.toLocaleString('id-ID');

    }

    function continueBooking() {

        if (selectedSeats.length === 0) {
            alert('Silakan pilih kursi terlebih dahulu!');
            return;
        }

        const form = document.createElement('form');

        form.method = 'POST';
        form.action = @json(route('booking.form', $schedule->id));

        const csrf = document.createElement('input');

        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = @json(csrf_token());

        form.appendChild(csrf);

        selectedSeats.forEach(seat => {

            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = 'seat_ids[]';
            input.value = seat.id;

            form.appendChild(input);

        });

        document.body.appendChild(form);

        form.submit();
    }


</script>

</body>
</html>
