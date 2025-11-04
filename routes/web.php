<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Movie Routes (CRUD)
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/create', [MovieController::class, 'create'])->middleware('auth')->name('movies.create');
Route::post('/movies', [MovieController::class, 'store'])->middleware('auth')->name('movies.store');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->middleware('auth')->name('movies.edit');
Route::put('/movies/{movie}', [MovieController::class, 'update'])->middleware('auth')->name('movies.update');
Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->middleware('auth')->name('movies.destroy');

// Rating Routes — only for submitting a rating for a movie
Route::post('/movies/{movie}/ratings', [RatingController::class, 'store'])
    ->middleware('auth') // only authenticated users can submit
    ->name('ratings.store');

require __DIR__.'/auth.php';
