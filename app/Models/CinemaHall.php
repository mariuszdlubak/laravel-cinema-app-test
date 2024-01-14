<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CinemaHall extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function cinemaSeats(): HasMany
    {
        return $this->hasMany(CinemaSeat::class);
    }

    public function movieSchedules(): HasMany
    {
        return $this->hasMany(MovieSchedule::class);
    }
}
