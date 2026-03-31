<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Formation>
 */
class FormationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $title = fake()->words(2, true);

        return [
            'category_id' => \App\Models\Category::inRandomOrder()->first()->id,
            'title_fr' => $title,
            'title_en' => $title,
            'slug_fr' => Str::slug($title),
            'slug_en' => Str::slug($title),
            'short_desc_fr' => fake()->sentence(),
            'short_desc_en' => fake()->sentence(),
            'desc_fr' => fake()->paragraph(),
            'desc_en' => fake()->paragraph(),
            'full_desc_fr' => fake()->text(),
            'full_desc_en' => fake()->text(),
            'image' => '',
            'price' => fake()->numberBetween(100, 2000),
            'duration' => fake()->randomElement(['1 mois', '3 mois', '6 mois']),
            'level' => fake()->randomElement(['débutant', 'intermédiaire', 'avancé']),
            'status' => fake()->randomElement(['brouillon', 'publie', 'archive']),
            'publication_date' => now(),
            'published_at' => now(),
            'seo_title_fr' => fake()->sentence(),
            'seo_title_en' => fake()->sentence(),
            'meta_desc_fr' => fake()->sentence(),
            'meta_desc_en' => fake()->sentence(),
        ];
    }
}
