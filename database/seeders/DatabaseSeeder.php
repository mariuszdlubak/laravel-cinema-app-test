<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Movie::factory(100)->create();

        \App\Models\User::factory()->create([
            'name' => 'Mariusz Dl',
            'login' => 'admin',
            'email' => 'mariusz@dl.com',
            'balance' => 0
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Mariusz Dl',
            'login' => 'mariusz',
            'email' => 'mariuszdl@dl.com',
            'balance' => 0
        ]);

        // \App\Models\Balance::factory()->create([
        //     'code' => '1234567899',
        //     'value' => 120.50,
        //     'active' => true
        // ]);

        // \App\Models\CinemaHall::factory()->create([
        //     'name' => '1'
        // ]);

        // $seats = 'ABCDEFGHIJ';

        // for ($r = 1; $r < 12; $r++) {
        //     for ($s = 0; $s < strlen($seats); $s++) {
        //         \App\Models\CinemaSeat::factory()->create([
        //             'cinema_hall_id' => 1,
        //             'row' => $r,
        //             'col' => $seats[$s],
        //             'seat' => $r . $seats[$s],
        //             'blocked' => false
        //         ]);
        //     }
        // }

        // \App\Models\MovieType::factory()->create([
        //     'movie_id' => 2,
        //     'type' => '3D',
        //     'language' => 'Lektor PL'
        // ]);

        // \App\Models\MovieSchedule::factory()->create([
        //     'movie_type_id' => 1,
        //     'cinema_hall_id' => 1,
        //     'date' => date('Y-m-d 17:00:00', strtotime('today')),
        //     'price' => 4.50
        // ]);

        // \App\Models\MovieSchedule::factory()->create([
        //     'movie_type_id' => 1,
        //     'cinema_hall_id' => 1,
        //     'date' => date('Y-m-d 19:00:00', strtotime('today')),
        //     'price' => 7.00
        // ]);
    }
}
