<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    public function definition()
    {
        return [
            'title_fr' => fake()->sentence(3),
            'title_en' => fake()->sentence(3),
            'formation_id' => \App\Models\Formation::inRandomOrder()->first()?->id
                ?? \App\Models\Formation::factory()->create()->id,
            'formateur_id' => \App\Models\User::where('role', 'formateur')
                ->inRandomOrder()->first()?->id
                ?? \App\Models\User::factory()->create(['role' => 'formateur'])->id,
            'start_date' => now()->addDays(rand(1, 10)),
            'end_date' => now()->addDays(rand(11, 30)),
            'capacity' => fake()->numberBetween(10, 50),
            'mode' => fake()->randomElement(['présentiel', 'en ligne', 'hybride']),
            'city' => fake()->city(),
            'meeting_link' => fake()->url(),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}