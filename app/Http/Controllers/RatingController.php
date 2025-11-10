<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RatingController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of all ratings (optional).
     */
    public function index()
    {
        $ratings = Rating::with('movie', 'user')->latest()->get();
        return view('ratings.index', compact('ratings'));
    }

    /**
     * Store a newly created rating for a specific movie.
     */
    public function store(Request $request, Movie $movie)
    {
        $existing = $movie->ratings()->where('user_id', auth()->id())->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You have already submitted a rating for this movie.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:200',
        ]);

        $movie->ratings()->create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Rating submitted successfully!');
    }

    /**
     * Display a specific rating (optional).
     */
    public function show(Rating $rating)
    {
        return view('ratings.show', compact('rating'));
    }

    /**
     * Show the form to edit a rating.
     */
    public function edit(Rating $rating)
    {
        $this->authorize('update', $rating);
        return view('ratings.edit', compact('rating'));
    }

    /**
     * Update a rating and redirect back to the movie show page.
     */
    public function update(Request $request, Rating $rating)
    {
        $this->authorize('update', $rating);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:200',
        ]);

        $rating->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Redirect back to the movie show page
        return redirect()->route('movies.show', $rating->movie->id)
                         ->with('success', 'Rating updated successfully!');
    }

    /**
     * Delete a rating.
     */
    public function destroy(Rating $rating)
    {
        $this->authorize('delete', $rating);
        $rating->delete();

        return redirect()->back()->with('success', 'Rating deleted!');
    }
}
