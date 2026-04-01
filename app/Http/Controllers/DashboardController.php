<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Formation;
use App\Models\Category;
use App\Models\Session;
use App\Models\Inscription;
use App\Models\Blog;

class DashboardController extends Controller
{
    public function admin()
    {
        $stats = [
            'users' => User::count(),
            'formations' => Formation::count(),
            'categories' => Category::count(),
            'sessions' => Session::count(),
            'inscriptions' => Inscription::count(),
            'blogs' => Blog::count(),
        ];

        $latestFormations = Formation::with('category')->latest()->take(5)->get();
        $latestInscriptions = Inscription::with('user', 'session')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestFormations', 'latestInscriptions'));
    }
}