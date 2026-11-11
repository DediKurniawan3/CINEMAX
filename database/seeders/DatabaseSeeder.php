<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Studio;
use App\Models\Seat;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DATA FILM BIOSKOP BANJARMASIN
        $films = [
            [
                'title' => 'Godzilla Minus Zero',
                'slug' => 'godzilla-minus-zero',
                'poster' => 'images/posters/godzilla-minus-zero.jpg',
                'genre' => 'Action, Sci-Fi, Thriller',
                'duration' => 135,
                'synopsis' => 'Godzilla kembali membawa kehancuran dan ancaman besar bagi umat manusia. Sebuah perjuangan untuk bertahan hidup dimulai ketika manusia menghadapi kekuatan monster yang luar biasa.',
                'age_rating' => 'R13+',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => 'Pirunduk',
                'slug' => 'pirunduk',
                'poster' => 'images/posters/pirunduk.jpg',
                'genre' => 'Horror',
                'duration' => 96,
                'synopsis' => 'Siti menikah dengan juragan Badarudin demi melunasi utang ayahnya. Namun, kehidupan rumah tangganya berubah menjadi penuh penderitaan hingga ia mempelajari ilmu hitam Pirunduk yang membawa konsekuensi mengerikan.',
                'age_rating' => 'R13',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => 'Gak Ada Matinya!',
                'slug' => 'gak-ada-matinya',
                'poster' => 'images/posters/gak-ada-matinya.jpg',
                'genre' => 'Comedy, Drama',
                'duration' => 102,
                'synopsis' => 'Kisah komedi tentang berbagai persoalan kehidupan, hubungan keluarga, dan kejadian tak terduga yang menghadirkan situasi penuh humor.',
                'age_rating' => 'R13',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => 'Laut Bercerita',
                'slug' => 'laut-bercerita',
                'poster' => 'images/posters/laut-bercerita.jpg',
                'genre' => 'Drama',
                'duration' => 135,
                'synopsis' => 'Biru Laut dan teman-temannya memperjuangkan kebebasan berekspresi di tengah situasi politik yang penuh tekanan. Ketika mereka menghilang, keluarga yang ditinggalkan berjuang mencari jawaban.',
                'age_rating' => 'D17',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => 'Putri, Jangan Gentayangan Lagi',
                'slug' => 'putri-jangan-gentayangan-lagi',
                'poster' => 'images/posters/putri-jangan-gentayangan-lagi.jpg',
                'genre' => 'Horror, Drama',
                'duration' => 104,
                'synopsis' => 'Kisah horor tentang teror misterius yang melibatkan sosok Putri dan rahasia kelam yang perlahan terungkap.',
                'age_rating' => 'R13',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => "Ramayana - Director's Cut",
                'slug' => 'ramayana-directors-cut',
                'poster' => 'images/posters/ramayana-directors-cut.jpg',
                'genre' => 'Fantasy, Action',
                'duration' => 208,
                'synopsis' => 'Kisah epik yang menghadirkan petualangan, konflik, dan pertarungan besar dalam dunia fantasi.',
                'age_rating' => '13+',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => 'GJLS: Berapi-Api',
                'slug' => 'gjls-berapi-api',
                'poster' => 'images/posters/gjls-berapi-api.jpg',
                'genre' => 'Comedy, Drama',
                'duration' => 110,
                'synopsis' => 'Rigen, Hifdzi, dan Rispo menghadirkan cerita komedi dengan berbagai konflik dan kejadian tak terduga yang mengundang tawa.',
                'age_rating' => 'R13',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
            [
                'title' => 'Rambut Sewu: Satu Langkah Getih',
                'slug' => 'rambut-sewu-satu-langkah-getih',
                'poster' => 'images/posters/rambut-sewu-satu-langkah-getih.jpg',
                'genre' => 'Horror, Drama',
                'duration' => 105,
                'synopsis' => 'Sebuah kisah horor yang menghadirkan misteri, teror, dan rahasia kelam yang mengancam kehidupan para tokohnya.',
                'age_rating' => '17+',
                'release_date' => now()->toDateString(),
                'status' => 'now_showing',
            ],
        ];

        foreach ($films as $filmData) {
            Film::updateOrCreate(
                ['slug' => $filmData['slug']],
                $filmData
            );
        }

        // 2. DATA STUDIO
        $studios = [
            [
                'name' => 'Studio 1',
                'studio_type' => 'Regular',
                'capacity' => 40,
            ],
            [
                'name' => 'Studio 2',
                'studio_type' => 'Premium',
                'capacity' => 40,
            ],
        ];

        $createdStudios = [];

        foreach ($studios as $studioData) {
            $studio = Studio::updateOrCreate(
                ['name' => $studioData['name']],
                $studioData
            );

            $createdStudios[] = $studio;

            // 3. MEMBUAT KURSI OTOMATIS
            foreach (['A', 'B', 'C', 'D', 'E'] as $row) {
                for ($number = 1; $number <= 8; $number++) {
                    Seat::firstOrCreate([
                        'studio_id' => $studio->id,
                        'row' => $row,
                        'seat_number' => $number,
                    ]);
                }
            }
        }

        // 4. MEMBUAT JADWAL TAYANG
        $allFilms = Film::whereIn(
            'slug',
            array_column($films, 'slug')
        )->get();

        $showtimes = [11, 14, 17, 20];

        foreach ($allFilms as $filmIndex => $film) {

            // Membagi film ke dua studio
            $studioIndex = $filmIndex % count($createdStudios);

            $studio = $createdStudios[$studioIndex];

            // Jadwal pukul 11.00, 14.00, 17.00, 20.00
            $hour = $showtimes[intdiv($filmIndex, count($createdStudios))];

            $start = now()
                ->addDay()
                ->startOfDay()
                ->addHours($hour);

            $end = $start->copy()
                ->addMinutes($film->duration + 15);

            Schedule::updateOrCreate(
                [
                    'film_id' => $film->id,
                    'studio_id' => $studio->id,
                    'start_time' => $start,
                ],
                [
                    'end_time' => $end,
                    'price' => $studioIndex === 0 ? 45000 : 60000,
                    'status' => 'active',
                ]
            );
        }
    }
}
