<?php

namespace App\Http\Controllers;

use App\Models\CinemaHall;
use App\Models\Movie;
use App\Models\MovieSchedule;
use App\Models\MovieType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class AdminSchedulesController extends Controller
{
    public function index(Request $request, Movie $movie)
    {
        $types = MovieType::where('movie_id', $movie->id)
            ->with(['movieSchedules' => function ($query) {
                $query->orderBy('date');
            }])
            ->get();

        $types->each(function ($type) use ($request) {
            $groupedSchedules = $type->movieSchedules->when($request->has('upcoming_only'), function ($schedules) {
                return $schedules->filter(function ($schedule) {
                    return Carbon::parse($schedule->date)->isFuture();
                });
            })->groupBy(function ($schedule) {
                return Carbon::parse($schedule->date)->format('Y-m-d');
            });

            $type->movieSchedules = $groupedSchedules->map(function ($schedules) {
                return $schedules->sortBy('date');
            });
        });

        return view(
            'admin.movie.schedules.index',
            [
                'movie' => $movie,
                'types' => $types
            ]
        );
    }

    public function create(Request $request, Movie $movie)
    {
        $cinemaHalls = CinemaHall::withCount(['cinemaSeats' => function ($query) {
            $query->where('blocked', 0);
        }])->get();
        
        if ($cinemaHalls->isEmpty()) {
            return redirect()->route('admin.cinemahalls.create')->with('error', 'There are no available cinema halls, add a hall and try again');
        }
        
        $movieTypes = $movie->movieTypes;

        $cinemaHall = $cinemaHalls->first();
        $requestDate = Carbon::now();

        $unavailableHours = [];
        $intervalsCountCurrentMovie = ceil(($movie->duration + 20) / 15);

        $availableHours = [];
        $firstAvailableHour = 9;
        $lastAvailableHour = 22.25;

        if($request->has('cinema_hall')) {
            $request->validate([
                'cinema_hall' => [
                    'required',
                    function ($attribute, $value, $fail) use ($cinemaHalls) {
                        if (!$cinemaHalls->contains($value)) {
                            $fail('The selected cinema hall is not valid');
                        }
                    }
                ]
            ]);
            $cinemaHall = $cinemaHalls->where('id', $request['cinema_hall'])->first();
        }

        if($request->has('movie_type')) {
            $request->validate([
                'movie_type' => [
                    'required',
                    function ($attribute, $value, $fail) use ($movieTypes) {
                        if (!$movieTypes->contains($value)) {
                            $fail('The selected movie type is not valid');
                        }
                    }
                ]
            ]);
        }

        if($request->has('price')) {
            $request->validate([
                'price' => 'required|numeric|min:1|max:500|regex:/^\d+(\.\d{1,2})?$/'
            ]);
        }

        if($request->has('start_date')) {
            $request->validate([
                'start_date' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (Carbon::parse($value)->lessThan(Carbon::now()->startOfDay())) {
                            $fail('The selected date must be today or later.');
                        }
                    },
                ],
            ]);
            $requestDate = Carbon::parse($request['start_date']);
        }

        if($request->has('repeat') && $request['repeat'] === 'on') {
            $request->validate([
                'start_date' => 'required|date',
                'days' => 'required|numeric|min:1|max:14',
                'end_date' => 'required|date|after:start_date'
            ]);
            $schedules = $cinemaHall->movieSchedules()
                ->whereDate('date', '>=', $requestDate->startOfDay())
                ->with('movieType.movie')
                ->get();
        } else {
            $schedules = $cinemaHall->movieSchedules()
                ->whereDate('date', '>=', $requestDate->startOfDay())
                ->whereDate('date', '<', $requestDate->copy()->startOfDay()->addDay())
                ->with('movieType.movie')
                ->get();
        }

        $currentDate = Carbon::now();
        if ($requestDate->isSameDay($currentDate)) {
            $currentDate = $currentDate->addMinutes(30);
            $dateTime = new DateTime($currentDate);
            $numericTime = $this->transformHourToNumeric($dateTime);
            $firstAvailableHour = ceil($numericTime);
        }

        do {
            $availableHours[] = $this->transformHour($firstAvailableHour);
            $firstAvailableHour += 0.25;
        } while($firstAvailableHour <= $lastAvailableHour);



        foreach ($schedules as $schedule) {
            $dateTime = new DateTime($schedule->date);
            $dateTime = $dateTime->modify('-' . $intervalsCountCurrentMovie * 15 . ' minutes');
            $numericTime = $this->transformHourToNumeric($dateTime);
            $intervalsCount = ceil(($schedule->movieType->movie->duration + 20) / 15) + $intervalsCountCurrentMovie;

            for($i = 0; $i < $intervalsCount; $i++) {
                $unavailableHours[] = $this->transformHour($numericTime);
                $numericTime += 0.25;
            }
        }

        $unavailableHours = array_unique($unavailableHours);
        $filteredAvailableHours = array_diff($availableHours, $unavailableHours);

        return view(
            'admin.movie.schedules.create',
            [
                'movie' => $movie,
                'movieTypes' => $movieTypes,
                'cinemaHalls' => $cinemaHalls,
                'cinemaHall' => $cinemaHall,
                'availableHours' => $filteredAvailableHours
            ]
        );
    }

    public function store(Request $request, Movie $movie)
    {
        $data = $request->only([
            'cinema_hall',
            'movie_type',
            'price',
            'start_date',
            'repeat',
            'days',
            'end_date',
            'hour'
        ]);

        $dateString = $data['start_date'] . ' ' . $data['hour'];
        $startDate = Carbon::parse($dateString);

        try {
            DB::beginTransaction();

            if($data['repeat'] === "false") {
                $schedule = new MovieSchedule([
                    'movie_type_id' => $data['movie_type'],
                    'cinema_hall_id' => $data['cinema_hall'],
                    'date' => $startDate,
                    'price' => $data['price']
                ]);
                $schedule->save();
            } else {
                $endDateString = $data['end_date'] . ' ' . $data['hour'];
                $endDate = Carbon::parse($endDateString);

                do {
                    $schedule = new MovieSchedule([
                        'movie_type_id' => $data['movie_type'],
                        'cinema_hall_id' => $data['cinema_hall'],
                        'date' => $startDate,
                        'price' => $data['price']
                    ]);
                    $schedule->save();
                    $startDate = $startDate->addDays($data['days']);
                } while($startDate->lessThanOrEqualTo($endDate));
            }

            DB::commit();

            return redirect()->route('admin.movies.schedules.index', $movie)->with('success', 'Schedule added successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit(Request $request, Movie $movie, MovieSchedule $schedule)
    {
        $requestDate = Carbon::now();
        if(Carbon::parse($schedule->date)->lt($requestDate)) {
            return redirect()->route('admin.movies.schedules.index', $movie)->with('error', 'You cannot update a screening that has already taken place');
        }

        if ($schedule->tickets->isNotEmpty()) {
            return redirect()->route('admin.movies.schedules.index', $movie)->with('error', 'You cannot update a screening for which someone has already purchased a ticket');
        }

        $cinemaHalls = CinemaHall::withCount(['cinemaSeats' => function ($query) {
            $query->where('blocked', 0);
        }])->get();
        
        if ($cinemaHalls->isEmpty()) {
            return redirect()->route('admin.cinemahalls.create')->with('error', 'There are no available cinema halls, add a hall and try again');
        }
        
        $movieTypes = $movie->movieTypes;

        $cinemaHall = $cinemaHalls->first();

        $unavailableHours = [];
        $intervalsCountCurrentMovie = ceil(($movie->duration + 20) / 15);

        $availableHours = [];
        $firstAvailableHour = 9;
        $lastAvailableHour = 22.25;

        if($request->has('cinema_hall')) {
            $request->validate([
                'cinema_hall' => [
                    'required',
                    function ($attribute, $value, $fail) use ($cinemaHalls) {
                        if (!$cinemaHalls->contains($value)) {
                            $fail('The selected cinema hall is not valid');
                        }
                    }
                ]
            ]);
            $cinemaHall = $cinemaHalls->where('id', $request['cinema_hall'])->first();
        }

        if($request->has('movie_type')) {
            $request->validate([
                'movie_type' => [
                    'required',
                    function ($attribute, $value, $fail) use ($movieTypes) {
                        if (!$movieTypes->contains($value)) {
                            $fail('The selected movie type is not valid');
                        }
                    }
                ]
            ]);
        }

        if($request->has('price')) {
            $request->validate([
                'price' => 'required|numeric|min:1|max:500|regex:/^\d+(\.\d{1,2})?$/'
            ]);
        }

        if($request->has('start_date')) {
            $requestDate = Carbon::parse($request['start_date']);
        }

        $schedules = $cinemaHall->movieSchedules()
            ->whereDate('date', '>=', $requestDate->startOfDay())
            ->whereDate('date', '<', $requestDate->startOfDay()->addDay())
            ->with('movieType.movie')
            ->get();

        $currentDate = Carbon::now();
        if ($requestDate->isSameDay($currentDate)) {
            $currentDate = $currentDate->addMinutes(30);
            $dateTime = new DateTime($currentDate);
            $numericTime = $this->transformHourToNumeric($dateTime);
            $firstAvailableHour = ceil($numericTime);
        }

        do {
            $availableHours[] = $this->transformHour($firstAvailableHour);
            $firstAvailableHour += 0.25;
        } while($firstAvailableHour <= $lastAvailableHour);

        foreach ($schedules as $scheduleData) {
            if($scheduleData->id !== $schedule->id) {
                $dateTime = new DateTime($scheduleData->date);
                $dateTime = $dateTime->modify('-' . $intervalsCountCurrentMovie * 15 . ' minutes');
                $numericTime = $this->transformHourToNumeric($dateTime);
                $intervalsCount = ceil(($scheduleData->movieType->movie->duration + 20) / 15) + $intervalsCountCurrentMovie;

                for($i = 0; $i < $intervalsCount; $i++) {
                    $unavailableHours[] = $this->transformHour($numericTime);
                    $numericTime += 0.25;
                }
            }
        }

        $unavailableHours = array_unique($unavailableHours);
        $filteredAvailableHours = array_diff($availableHours, $unavailableHours);

        return view(
            'admin.movie.schedules.edit',
            [
                'movie' => $movie,
                'schedule' => $schedule,
                'movieTypes' => $movieTypes,
                'cinemaHalls' => $cinemaHalls,
                'cinemaHall' => $cinemaHall,
                'availableHours' => $filteredAvailableHours
            ]
        );
    }

    public function update(Request $request, Movie $movie, MovieSchedule $schedule)
    {
        $request->validate([
            'cinema_hall' => 'required',
            'movie_type' => 'required',
            'price' => 'required',
            'start_date' => 'required',
            'hour' => 'required'
        ]);

        $dateString = $request['start_date'] . ' ' . $request['hour'];
        $startDate = Carbon::parse($dateString);

        $schedule->update([
            'movie_type_id' => $request['movie_type'],
            'cinema_hall_id' => $request['cinema_hall'],
            'date' => $startDate,
            'price' => $request['price']
        ]);

        return redirect()->route('admin.movies.schedules.index', $movie)->with('success', 'Schedule updated successfully');
    }

    private function transformHourToNumeric(DateTime $dateTime) {
        $hours = $dateTime->format('H');
        $minutes = $dateTime->format('i');
        return floatval($hours) + floatval($minutes / 60);
    }

    private function transformHour(float $hourToTransform) {
        $hour = floor($hourToTransform);
        $minutes = sprintf('%02d', ($hourToTransform - $hour) * 60);
        return $hour . ':' . $minutes;
    }
}


// Dodaj aktualizowanie, rejestracje, przypominanie hasła oraz ustawienia blokujące rejestracje i przypomnienie hasła
