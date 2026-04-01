<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Formation;
use App\Models\Session;
use App\Models\Inscription;
use App\Models\Blog;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */


    public function run()
    {
        // 1. Users
        User::factory(10)->create();

        // 2. Categories
        Category::factory(5)->create();

        // 3. Formations
        Formation::factory(10)->create();

        // 4. Sessions
        Session::factory(15)->create();

        // 5. Inscriptions
        Inscription::factory(20)->create();

        // 6. Blogs
        Blog::factory(10)->create();
    }
}
