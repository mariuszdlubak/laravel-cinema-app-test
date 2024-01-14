<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\MovieType::class)->constrained();
            $table->foreignIdFor(\App\Models\CinemaHall::class)->constrained();
            $table->dateTime('date');             // data i godzina
            $table->double('price');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_schedules');
    }
};
