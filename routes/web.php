<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Http\Middleware\EnsureEmailIsVerified;
use App\Http\Controllers\RoundController;

Route::get('/', function (Request $request) {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'inviteGameCode' => $request->input('inviteGameCode')
    ]);
})->name('welcome');

Route::get('/game/{gameId}/{gameCode}', function ($gameId, $gameCode) {
    return Inertia::render('Game', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'gameId' => $gameId,
        'gameCode' => $gameCode,
    ]);
})->middleware(EnsureEmailIsVerified::class);;
;
// ->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profilße', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/test/', [RoundController::class, 'test']);

require __DIR__.'/auth.php';