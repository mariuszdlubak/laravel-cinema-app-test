<?php

namespace App\Http\Controllers;
use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\MovieType;
use App\Models\Ticket;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('release_date', 'DESC')->limit(5)->get();
        $baners = $movies->pluck('baner_path')->toArray();
        $links = $movies->pluck('id')->toArray();

        $ticketsLastWeek = Ticket::where('created_at', '>=', Carbon::now()->subWeek())
            ->get()
            ->pluck('movie_schedule_id')
            ->unique()
            ->values();

        $topTypesLastWeek = MovieSchedule::whereIn('id', $ticketsLastWeek)
            ->get()
            ->pluck('movie_type_id')
            ->unique()
            ->values();

        $topMoviesLastWeek = MovieType::whereIn('id', $topTypesLastWeek)
            ->get()
            ->pluck('movie_id')
            ->unique()
            ->values();

        $topMoviesIdFromTickets = Movie::whereIn('id', $topMoviesLastWeek)
            ->get()
            ->pluck('id')
            ->unique()
            ->values();

        $topMoviesFromTickets = Movie::select('id', 'icon_path', 'title')->whereIn('id', $topMoviesIdFromTickets)
            ->get();

        $newFilms = Movie::select('id', 'icon_path', 'title')->whereNotIn('id', $topMoviesIdFromTickets)->orderBy('created_at', 'DESC')->limit(3 - count($topMoviesFromTickets))
            ->get();

        $popularMovies = $topMoviesFromTickets->concat($newFilms);

        return view(
            'home.index',
            [
                'movies' => $movies,
                'baners' => $baners,
                'links' => $links,
                'popularMovies' => $popularMovies
            ]
        );
    }
}
