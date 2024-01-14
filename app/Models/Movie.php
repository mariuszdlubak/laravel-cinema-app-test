<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'release_date',
        'duration',
        'description',
        'fun_fact',
        'genre',
        'cast',
        'director',
        'production',
        'original_language',
        'age_restrictions',
        'icon_path',
        'baner_path',
        'trailer_path'
    ];

    public static array $category = [
        'Action',
        'Adventure',
        'Comedy',
        'Drama',
        'Fantasy',
        'Horror',
        'Science Fiction',
        'Thriller',
        'Romance'
    ];

    public static function days() {
        $currentDay = now()->dayOfWeek;
        $daysOfWeek = collect(['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
        $today = $daysOfWeek[$currentDay];
        $daysOfWeek = collect($daysOfWeek->slice($currentDay)->merge($daysOfWeek->take($currentDay))->toArray());

        return $daysOfWeek->mapWithKeys(function ($day) use ($today) {
            if($day === $today) {
                return [
                    substr($day, 0, 3) => now()->format('Y-m-d'),
                ];
            } else {
                return [
                    substr($day, 0, 3) => now()->next($day)->format('Y-m-d'),
                ];
            }
        });
    }

    public function movieTypes(): HasMany
    {
        return $this->hasMany(MovieType::class);
    }

    public function scopeFilter(Builder | QueryBuilder $query, array $filters): Builder | QueryBuilder
    {
        return $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('genre', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('movieTypes', function ($subquery) use ($search) {
                        $subquery->where('type', 'LIKE', '%' . $search . '%')
                            ->orWhere('language', 'LIKE', '%' . $search . '%');
                    });
            });
        })->when($filters['length_from'] ?? null, function ($query, $minLength) {
            $query->where('duration', '>=', $minLength);
        })->when($filters['length_to'] ?? null, function ($query, $maxLength) {
            $query->where('duration', '<=', $maxLength);
        })->when($filters['categories'] ?? null, function ($query, $categories) {
            $query->whereIn('genre', $categories);
        });
    }
}
