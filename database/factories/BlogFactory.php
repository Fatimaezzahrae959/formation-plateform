<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BlogFactory extends Factory
{
    public function definition()
    {
        $titleFr = fake()->sentence(4);
        $titleEn = fake()->sentence(4);
        $status = fake()->randomElement(['brouillon', 'publie', 'archive']);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id
                ?? Category::factory()->create()->id,
            'user_id' => User::whereIn('role', ['admin', 'super_admin', 'formateur'])
                ->inRandomOrder()->first()?->id
                ?? User::factory()->create(['role' => 'admin'])->id,
            'title_fr' => $titleFr,
            'title_en' => $titleEn,
            'slug_fr' => Str::slug($titleFr) . '-' . fake()->unique()->numberBetween(1, 9999),
            'slug_en' => Str::slug($titleEn) . '-' . fake()->unique()->numberBetween(1, 9999),
            'content_fr' => fake()->paragraphs(3, true),
            'content_en' => fake()->paragraphs(3, true),
            'image' => null,
            'status' => $status,
            'published_at' => $status === 'publie' ? fake()->dateTimeBetween('-1 year', 'now') : null,
            'seo_title_fr' => fake()->sentence(5),
            'seo_title_en' => fake()->sentence(5),
            'meta_desc_fr' => fake()->sentence(10),
            'meta_desc_en' => fake()->sentence(10),
        ];
    }
}