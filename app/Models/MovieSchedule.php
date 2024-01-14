<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_type_id',
        'cinema_hall_id',
        'date',
        'price'
    ];

    public function movieType(): BelongsTo
    {
        return $this->belongsTo(MovieType::class);
    }

    public function cinemaHall(): BelongsTo
    {
        return $this->belongsTo(CinemaHall::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
