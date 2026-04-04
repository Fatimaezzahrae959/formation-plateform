<?php

use App\Http\Controllers\API\ApiController;
use Illuminate\Support\Facades\Route;

// API Publique
Route::get('formations', [ApiController::class, 'formations']);
Route::get('formations/{slug}', [ApiController::class, 'formationDetail']);
Route::get('categories', [ApiController::class, 'categories']);

// API Protégée (nécessite token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('logout', [ApiController::class, 'logout']);
    Route::get('profile', [ApiController::class, 'profile']);

    // Inscriptions
    Route::get('my-inscriptions', [ApiController::class, 'myInscriptions']);
    Route::post('inscriptions', [ApiController::class, 'storeInscription']);
    Route::get('inscriptions/{id}', [ApiController::class, 'showInscription']);
    Route::delete('inscriptions/{id}', [ApiController::class, 'cancelInscription']);
});

// Login (public)
Route::post('login', [ApiController::class, 'login']);