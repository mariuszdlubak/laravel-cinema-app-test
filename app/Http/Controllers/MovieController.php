<?php

namespace App\Http\Controllers;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\Ticket;
use Carbon\Carbon;

class MovieController extends Controller
{
    public function index()
    {
        $filters = request()->only(
            'search',
            'length_from',
            'length_to',
            'categories'
        );

        $day = request('day') ?? now()->format('Y-m-d');

        $filteredMovies = Movie::with('movieTypes.movieSchedules')
            ->whereHas('movieTypes.movieSchedules', function ($query) use ($day) {
                $query->whereDate('date', '=', $day)->orderBy('date');
            })
            ->with(['movieTypes.movieSchedules' => function ($query) use ($day) {
                $query->whereDate('date', '=', $day)->orderBy('date');
            }])
            ->filter($filters)
            ->latest()
            ->paginate(25);

        $tickets = Ticket::with('movieSchedule')
            ->whereHas('movieSchedule', function ($query) use ($day) {
                $query->whereDate('date', '=', $day);
            })
            ->get();
        $cinemaHalls = CinemaHall::with('cinemaSeats')->get();

        return view(
            'movie.index', [
                'movies' => $filteredMovies,
                'tickets' => $tickets,
                'cinemaHalls' => $cinemaHalls
            ]
        );
    }

    public function show(Movie $movie)
    {
        $schedules = MovieSchedule::whereHas('movieType', function ($query) use ($movie) {
            $query->where('movie_id', $movie->id);
        })->where('date', '>=', Carbon::now()->startOfDay())->with('movieType')->orderBy('date', 'ASC')->get();

        $groupedSchedules = [];

        foreach ($schedules as $schedule) {
            $date = Carbon::parse($schedule->date)->format('Y-m-d');
            $type = $schedule->movieType->type;
            $language = $schedule->movieType->language;

            $groupedSchedules[$date][$type . '|' . $language][] = $schedule;
        }

        return view('movie.show', [
            'movie' => $movie,
            'groupedSchedules' => $groupedSchedules,
            'tickets' => Ticket::all(),
            'cinemaHalls' => CinemaHall::with('cinemaSeats')->get()
        ]);
    }
}
