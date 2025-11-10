<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\GenreController;
use Illuminate\Support\Facades\Route;

// ----------------------------
// Homepage & Dashboard
// ----------------------------
Route::get('/', fn() => view('welcome'));
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ----------------------------
// Profile Routes
// ----------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ----------------------------
// Movie Routes (CRUD)
// ----------------------------
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

Route::middleware('auth')->group(function () {
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');

    // Submit a rating for a movie
    Route::post('/movies/{movie}/ratings', [RatingController::class, 'store'])->name('ratings.store');

    // Edit/delete user's own ratings
    Route::get('/ratings/{rating}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

// ----------------------------
// Admin Routes
// ----------------------------
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Genre management (admin)
    Route::resource('genres', GenreController::class);

    // Admin Ratings management
    Route::get('/movies/{movie}/ratings', [AdminRatingController::class, 'index'])->name('ratings.index');
    Route::get('/ratings/{rating}/edit', [AdminRatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/ratings/{rating}', [AdminRatingController::class, 'update'])->name('ratings.update');
    Route::delete('/ratings/{rating}', [AdminRatingController::class, 'destroy'])->name('ratings.destroy');
});

require __DIR__.'/auth.php';
