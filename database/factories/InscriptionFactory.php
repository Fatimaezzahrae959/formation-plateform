<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InscriptionFactory extends Factory
{
    public function definition()
    {
        $status = fake()->randomElement(['pending', 'confirmed', 'cancelled']);

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id
                ?? \App\Models\User::factory()->create()->id,
            'session_id' => \App\Models\Session::inRandomOrder()->first()?->id
                ?? \App\Models\Session::factory()->create()->id,
            'reference' => 'INS-' . strtoupper(fake()->unique()->bothify('####??##')),
            'status' => $status,
            'note' => fake()->optional()->sentence(),
            'confirmed_at' => $status === 'confirmed' ? now() : null,
            'cancelled_at' => $status === 'cancelled' ? now() : null,
        ];
    }
}