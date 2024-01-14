<?php

namespace App\Http\Controllers;

use App\Models\CinemaSeat;
use App\Models\MovieSchedule;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        return view(
            'tickets.index',
            [
                'tickets' => Ticket::with([
                    'movieSchedule' => function ($query) {
                        $query->select('id', 'date', 'movie_type_id');
                    },
                    'movieSchedule.movieType' => function ($query) {
                        $query->select('id', 'type', 'language', 'movie_id');
                    },
                    'movieSchedule.movieType.movie' => function ($query) {
                        $query->select('id', 'title', 'icon_path', 'duration');
                    },
                    'cinemaSeat' => function ($query) {
                        $query->select('id', 'cinema_hall_id', 'seat');
                    },
                    'cinemaSeat.cinemaHall' => function ($query) {
                        $query->select('id', 'name');
                    }
                ])->where('user_id', auth()->user()->id)->latest()->get()
            ]
        );
    }

    public function create(MovieSchedule $movieSchedule)
    {
        if (!\Carbon\Carbon::parse($movieSchedule->date)->addMinutes(30)->isFuture()) {
            return redirect()->back()->with('error', 'You can no longer purchase tickets for this movie.');
        }

        $movieSchedule->load('movieType.movie');

        $seats = CinemaSeat::where('cinema_hall_id', $movieSchedule->cinema_hall_id)
            ->orderBy('row', 'ASC')
            ->orderBy('col', 'ASC')
            ->get();

        $seatsInRow = $seats->groupBy('row')->map(function ($row) {
            return $row->map(function ($seat) {
                return (object) [
                    'id' => $seat->id,
                    'seat' => $seat->seat,
                    'blocked' => $seat->blocked,
                ];
            })->toArray();
        })->toArray();

        $seatsInRow = array_values($seatsInRow);

        $rowsCount = count($seatsInRow);
        $seatsInRowCount = count($seatsInRow[1]);

        $allBlockedInRow = [];
        $lastBlockedSeats = [];
        $reversedSeatsInRow = array_reverse($seatsInRow);

        foreach($reversedSeatsInRow as $row) {
            $blockedInThisRow = 0;
            foreach($row as $seat) {
                if($seat->blocked === 1) $blockedInThisRow++;
            }
            $allBlockedInRow[] = $blockedInThisRow === $seatsInRowCount ? 1 : 0;
        }

        $countBlockedRows = 0;
        foreach ($allBlockedInRow as $blocked) {
            if ($blocked === 1) {
                $countBlockedRows++;
            } else {
                break;
            }
        }

        foreach($seatsInRow as $row) {
            $blockedInThisRow = 0;
            $reversedRow = array_reverse($row);
            foreach($reversedRow as $seat) {
                if($seat->blocked === 1) {
                    $blockedInThisRow++;
                } else {
                    break;
                }
            }
            $lastBlockedSeats[] = $blockedInThisRow;
        }

        $activeRows = $rowsCount - $countBlockedRows;
        $activeSeatsInRow = $seatsInRowCount - min($lastBlockedSeats);

        $seatsInRow = array_slice($seatsInRow, 0, $activeRows);

        foreach ($seatsInRow as &$row) {
            $row = array_slice($row, 0, $activeSeatsInRow);
        }

        return view(
            'tickets.create',
            [
                'seats' => $seatsInRow,
                'movieSchedule' => $movieSchedule,
                'occupiedSeats' => Ticket::where('movie_schedule_id', $movieSchedule->id)->pluck('cinema_seat_id')->toArray()
            ]
        );
    }

    public function store(Request $request, MovieSchedule $movieSchedule)
    {
        if (!\Carbon\Carbon::parse($movieSchedule->date)->addMinutes(30)->isFuture()) {
            return redirect()->back()->with('error', 'You can no longer purchase tickets for this movie.');
        }

        $selectedSeats = [];

        foreach ($request->all() as $key => $value) {
            if ($value === 'on') {
                $selectedSeats[] = ['seat' => $key];
            }
        }

        if(empty($selectedSeats)) {
            return redirect()->back()->with('error', 'Something went wrong');
        }

        $existingTickets = Ticket::where('movie_schedule_id', $movieSchedule->id)
            ->whereIn('cinema_seat_id', $selectedSeats)
            ->exists();

        if ($existingTickets) {
            return redirect()->back()->with('error', 'Selected seats are already occupied.');
        }

        $user = auth()->user();

        $price = $movieSchedule->price * count($selectedSeats);
        $userBalance = $user->balance;

        if($userBalance < $price) {
            return redirect()->route('balance.create')->with('error', 'Top up your account to purchase tickets.');
        }

        try {
            DB::beginTransaction();

            foreach ($selectedSeats as $selectedSeat) {
                $ticket = new Ticket([
                    'movie_schedule_id' => $movieSchedule->id,
                    'cinema_seat_id' => $selectedSeat['seat'],
                    'user_id' => auth()->user()->id
                ]);
                $ticket->save();
            }

            $user->update(['balance' => $userBalance - $price]);

            DB::commit();

            return redirect()->route('tickets.index')->with('success', 'Tickets have been purchased.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
