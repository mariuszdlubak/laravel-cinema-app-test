<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieType extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'language'];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function movieSchedules(): HasMany
    {
        return $this->hasMany(MovieSchedule::class);
    }
}
