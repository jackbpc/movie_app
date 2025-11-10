<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;

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
    ->middleware('auth')
    ->name('ratings.store');

// ----------------------------
// User Rating Routes (for normal users)
// ----------------------------
Route::middleware('auth')->group(function () {
    // Edit your own rating
    Route::get('/ratings/{rating}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

// ----------------------------
// Admin Ratings Routes
// ----------------------------
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // View all ratings for a specific movie
    Route::get('/movies/{movie}/ratings', [AdminRatingController::class, 'index'])
        ->name('ratings.index');

    // Edit a specific rating (admin)
    Route::get('/ratings/{rating}/edit', [AdminRatingController::class, 'edit'])
        ->name('ratings.edit');

    // Update a rating (admin)
    Route::put('/ratings/{rating}', [AdminRatingController::class, 'update'])
        ->name('ratings.update');

    // Delete a rating (admin)
    Route::delete('/ratings/{rating}', [AdminRatingController::class, 'destroy'])
        ->name('ratings.destroy');
});

require __DIR__.'/auth.php';
