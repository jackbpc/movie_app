<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of ratings for a specific movie.
     */
    public function index(Movie $movie)
    {
        $ratings = $movie->ratings()->latest()->get();
        return view('admin.ratings.index', compact('movie', 'ratings'));
    }

    /**
     * Show the form for editing a specific rating.
     */
    public function edit(Rating $rating)
    {
        return view('admin.ratings.edit', compact('rating'));
    }

    /**
     * Update a specific rating in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:200',
        ]);

        $rating->update($request->only('rating', 'comment'));

        return redirect()->route('admin.ratings.index', $rating->movie_id)
                         ->with('success', 'Rating updated successfully.');
    }

    /**
     * Remove a rating from storage.
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();

        return back()->with('success', 'Rating deleted successfully.');
    }
}
