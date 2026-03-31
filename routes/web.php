<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

// Register
Route::get('/register', [RegisterController::class, 'show'])
    ->name('register.show');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register.store');

// Login
Route::get('/login', [LoginController::class, 'show'])
    ->name('login.show');

Route::get('/login', [LoginController::class, 'show'])->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.store');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');



Route::get('/dashboard', function () {
    return "Bienvenue Dashboard";
})->name('dashboard')->middleware('auth');

Route::get('/admin', function () {
    return "Admin Dashboard";
})->middleware(['auth', 'role:admin,super_admin'])->name('admin.dashboard');


Route::get('/formateur', function () {
    return "Formateur Dashboard";
})->middleware(['auth', 'role:formateur'])->name('formateur.dashboard');


Route::get('/participant', function () {
    return "Participant Dashboard";
})->middleware(['auth', 'role:participant'])->name('participant.dashboard');


use App\Http\Controllers\CategoryController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
});

use App\Http\Controllers\FormationController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('formations', FormationController::class);
    Route::get('/fr/formations/{slug}', [FormationController::class, 'showFr']);
    Route::get('/en/trainings/{slug}', [FormationController::class, 'showEn']);
});




use App\Http\Controllers\SessionController;
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('sessions', SessionController::class);
});

use App\Http\Controllers\InscriptionController;

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('inscriptions', InscriptionController::class);
});

use App\Http\Controllers\UserController;
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
});