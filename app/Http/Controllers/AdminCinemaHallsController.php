<?php

namespace App\Http\Controllers;

use App\Models\CinemaHall;
use App\Models\Ticket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCinemaHallsController extends Controller
{
    private $defaultRows = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
    private $defaultSeats = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];

    public function index()
    {
        $cinemaHalls = CinemaHall::withCount(['cinemaSeats as seats_count' => function ($query) {
                $query->where('blocked', 0);
            }])->get();

        return view(
            'admin.cinemahalls.index',
            [
                'cinemaHalls' => $cinemaHalls
            ]
        );
    }

    public function create()
    {
        $latestCinemaHall = CinemaHall::latest()->first();

        return view(
            'admin.cinemahalls.create',
            [
                'name' => $latestCinemaHall ? $latestCinemaHall->id + 1 : 1,
                'rows' => $this->defaultRows,
                'seats' => $this->defaultSeats
            ]
        );
    }

    public function store(Request $request)
    {
        $latestCinemaHall = CinemaHall::latest()->first();
        $newCinemaHallName = $latestCinemaHall ? $latestCinemaHall->id + 1 : 1;

        $blockedSeats = [];

        foreach ($request->all() as $key => $value) {
            if ($value === 'on') {
                $blockedSeats[] = $key;
            }
        }

        try {
            DB::beginTransaction();

            $newCinemaHall = new CinemaHall([
                'name' => $newCinemaHallName
            ]);
            $newCinemaHall->save();

            foreach($this->defaultRows as $row) {
                foreach($this->defaultSeats as $col) {
                    $newCinemaHall->cinemaSeats()->create([
                        'row' => $row,
                        'col' => $col,
                        'seat' => $row . $col,
                        'blocked' => in_array($row . $col, $blockedSeats) ? 1 : 0
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.cinemahalls.index')->with('success', 'Hall created successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function edit(CinemaHall $cinemaHall)
    {
        $blockedSeats = array_column($cinemaHall->cinemaSeats->where('blocked', 1)->toArray(), 'seat');

        return view(
            'admin.cinemahalls.edit',
            [
                'cinemaHall' => $cinemaHall,
                'blockedSeats' => $blockedSeats,
                'rows' => $this->defaultRows,
                'seats' => $this->defaultSeats
            ]
        );
    }

    public function update(Request $request, CinemaHall $cinemaHall)
    {
        $changedSeats = [];

        foreach ($request->all() as $key => $value) {
            if ($value === 'on') {
                $changedSeats[] = $key;
            }
        }

        $notAvailableToUpdate = [];
        $futureSchedules = $cinemaHall->movieSchedules->where('date', '>=', now())->all();

        foreach($futureSchedules as $schedule) {
            $notAvailableToUpdate[] = $schedule->id;
        }

        if(Ticket::whereIn('movie_schedule_id', $notAvailableToUpdate)->count()) {
            return redirect()->route('admin.cinemahalls.index')->with('error', 'You cannot edit the hall for which tickets have already been sold');
        }

        try {
            DB::beginTransaction();

            foreach ($changedSeats as $seat) {
                $seat = $cinemaHall->cinemaSeats()->where('seat', $seat)->first();
                if($seat) {
                    $seat->update([
                        'blocked' => $seat->blocked === 1 ? 0 : 1
                    ]);
                } else {
                    throw new Exception;
                }
            }

            DB::commit();

            return redirect()->route('admin.cinemahalls.index')->with('success', 'Hall updated successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
