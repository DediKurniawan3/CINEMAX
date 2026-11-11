<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Schedule;

class HomeController extends Controller
{
    public function index()
    {
        $nowShowing = Film::where('status', 'now_showing')
            ->latest()
            ->get();

        $comingSoon = Film::where('status', 'coming_soon')
            ->latest()
            ->get();

        $featuredFilm = Film::where('status', 'now_showing')
            ->first();

        return view('home', compact(
            'nowShowing',
            'comingSoon',
            'featuredFilm'
        ));
    }
    public function show($slug)
    {
        $film = Film::where('slug', $slug)
            ->firstOrFail();

        $schedules = Schedule::with('studio')
            ->where('film_id', $film->id)
            ->where('status', 'active')
            ->where('start_time', '>', now())
            ->orderBy('start_time')
            ->get();

        return view('detail', compact('film', 'schedules'));
    }
}
