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
        Schema::create('movie_types', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(\App\Models\Movie::class)->constrained();
            $table->string('type');             // typ 3D, 2D itp.
            $table->string('language');         // język (dubbing, lektor pl, napisy pl)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_types');
    }
};
