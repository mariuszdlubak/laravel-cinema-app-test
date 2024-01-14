<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(2),
            'release_date' => fake()->dateTimeBetween('now', '20.12.2023'),
            'duration' => fake()->numberBetween(76, 180),
            'description' => fake()->paragraph(10),
            'fun_fact' => fake()->paragraph(3),
            'genre' => 'Akcja',
            'cast' => fake()->name(),
            'director' => fake()->name(),
            'production' => fake()->company(),
            'original_language' => 'English',
            'age_restrictions' => 16,
            'icon_path' => 'https://www.cinema-city.pl/xmedia-cw/repo/feats/posters/5958O2R.jpg',
            'baner_path' => 'https://hubertkajdan.com/wp-content/uploads/2019/06/2019-06-20-Jezioro-Lednickie-010-Pano-1024x663.jpg',
            'trailer_path' => 'https://www.youtube.com/embed/s_76M4c4LTo?si=TK1tL3C7bQPhRm5r'
        ];
    }
}
