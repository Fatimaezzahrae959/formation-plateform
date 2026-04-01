<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;

// ─── Auth ───────────────────────────────────────────
Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Home ────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ─── Dashboards ──────────────────────────────────────
// Route::get('/dashboard', fn() => "Bienvenue Dashboard")->name('dashboard')->middleware('auth');
// Route::get('/admin', fn() => "Admin Dashboard")->middleware(['auth', 'role:admin,super_admin'])->name('admin.dashboard');
// Route::get('/formateur', fn() => "Formateur Dashboard")->middleware(['auth', 'role:formateur'])->name('formateur.dashboard');
// Route::get('/participant', fn() => "Participant Dashboard")->middleware(['auth', 'role:participant'])->name('participant.dashboard');

// ─── Admin CRUD ──────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin', 'last.activity'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('formations', FormationController::class)->except(['show']);
    Route::resource('sessions', SessionController::class)->except(['show']);
    Route::resource('inscriptions', InscriptionController::class)->except(['show']);
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('blogs', BlogController::class)->except(['show']);
});

// ─── Pages publiques (SEO-friendly) ──────────────────
Route::get('/formation/{slug}', [FormationController::class, 'show'])->name('formations.show');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blogs.show');


// ─── Lang Switcher ─────────────────────────────────────
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');