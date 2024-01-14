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
        Schema::create('cinema_seats', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\CinemaHall::class)->constrained();
            $table->unsignedInteger('row');
            $table->char('col');
            $table->string('seat');
            $table->boolean('blocked');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinema_seats');
    }
};
