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

// Auth-protected movie routes
Route::middleware('auth')->group(function () {
    // Create movie
    Route::get('/movies/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/movies', [MovieController::class, 'store'])->name('movies.store');

    // Edit movie
    Route::get('/movies/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/movies/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/movies/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');

    // Submit a new rating
    Route::post('/movies/{movie}/ratings', [RatingController::class, 'store'])->name('ratings.store');

    // Edit user's own rating
    Route::get('/ratings/{rating}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/ratings/{rating}', [RatingController::class, 'update'])->name('ratings.update');

    // Delete user's own rating
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

// Show movie route (must be **after** create/edit routes to avoid conflicts)
Route::get('/movies/{movie}', [MovieController::class, 'show'])
    ->where('movie', '[0-9]+')
    ->name('movies.show');

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
