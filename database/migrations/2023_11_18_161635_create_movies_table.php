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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();

            // $table->dateTime
            $table->string('title');                // tytuł
            $table->dateTime('release_date');       // data premiery
            $table->unsignedInteger('duration');    // długość
            $table->text('description');            // opis
            $table->text('fun_fact');               // ciekawostka
            $table->string('genre');                // gatunek
            $table->string('cast');                 // obsada
            $table->string('director');             // reżyser
            $table->string('production');           // produkcja
            $table->string('original_language');    // oryginalny język
            $table->string('age_restrictions');     // ograniczenia wiekowe
            $table->string('icon_path');            // link do ikony
            $table->string('baner_path');           // link do banera
            $table->string('trailer_path');         // link do trailera na yt

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
