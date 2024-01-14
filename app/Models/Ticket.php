<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['movie_schedule_id', 'cinema_seat_id', 'user_id'];

    public function movieSchedule(): BelongsTo
    {
        return $this->belongsTo(MovieSchedule::class);
    }

    public function cinemaSeat(): BelongsTo
    {
        return $this->belongsTo(CinemaSeat::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
