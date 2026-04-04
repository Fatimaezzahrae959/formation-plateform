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
Route::get('/login', [LoginController::class, 'show'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ─── Password Reset Routes (AJOUTER CECI) ───────────
Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

// ─── Email Verification Routes (AJOUTER CECI) ───────
Route::get('/email/verify', [App\Http\Controllers\Auth\EmailVerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [App\Http\Controllers\Auth\EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/verification-notification', [App\Http\Controllers\Auth\EmailVerificationController::class, 'send'])->name('verification.send');

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
Route::prefix('admin')->middleware(['auth', 'role:admin,super_admin', 'last.activity'])->group(function () {
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


// ─── AJAX Routes ─────────────────────────────────────
use App\Http\Controllers\AjaxController;

Route::prefix('ajax')->group(function () {

    // DELETE
    Route::delete('{table}/{id}', [AjaxController::class, 'delete'])->name('ajax.delete');

    // Toggle status (ex: active/inactive)
    Route::post('{table}/{id}/toggle-status', [AjaxController::class, 'toggleStatus'])->name('ajax.toggleStatus');

    // Live search
    Route::get('{table}/search', [AjaxController::class, 'search'])->name('ajax.search');

});

// Route pour récupérer les sessions d'une formation (ex: pour le formateur lors de la création d'une session)
Route::get('/ajax/formations/{id}/sessions', [AjaxController::class, 'getFormationSessions'])
    ->name('ajax.formation.sessions')
    ->middleware(['auth', 'role:admin']);

use App\Http\Controllers\ContactController;

// Public
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/contacts', [ContactController::class, 'adminIndex'])->name('contacts.index');
    Route::patch('/contacts/{contact}/status', [ContactController::class, 'updateStatus'])->name('contacts.status');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});


use App\Http\Controllers\FormateurController;
use App\Http\Controllers\ParticipantController;

Route::prefix('formateur')->middleware(['auth', 'role:formateur'])->group(function () {
    Route::get('/dashboard', [FormateurController::class, 'dashboard'])->name('formateur.dashboard');
});

Route::prefix('participant')->middleware(['auth', 'role:participant'])->group(function () {
    Route::get('/dashboard', [ParticipantController::class, 'dashboard'])->name('participant.dashboard');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return back();
})->name('lang.switch');