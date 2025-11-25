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
     * Store a newly created rating for a specific movie.
     */
    public function store(Request $request, Movie $movie)
    {
        $user = $request->user();

        // Prevent multiple ratings by the same user
        $existing = $movie->ratings()->where('user_id', $user->id)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You have already submitted a rating for this movie.');
        }



        // Validate input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:200',
        ]);

        // Create rating
        $movie->ratings()->create([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Rating submitted successfully!');
    }

    /**
     * Show the form to edit a rating.
     */
    public function edit(Rating $rating)
    { 
        $user = auth()->user();

        // Admins can edit any rating, users only their own
        if ($user->role !== 'admin' && $rating->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

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

        return redirect()->route('movies.show', $rating->movie->id)
                         ->with('success', 'Rating updated successfully!');
    }

    /**
     * Delete a rating.
     */
    public function destroy(Rating $rating)
    {
        $user = auth()->user();

        // Admins can delete any rating, users can delete only their own
        if ($user->role !== 'admin' && $rating->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $rating->delete();

        return back()->with('success', 'Rating deleted successfully.');
    }


    /**
     * Display all ratings (admin only).
     */
    public function index()
    {
        $ratings = Rating::with('movie', 'user')->latest()->get();
        return view('ratings.index', compact('ratings'));
    }
}
