<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
            public function index(Request $request)
    {
        $query = Movie::query()->with(['genres', 'ratings']);

        // Filter by genre if selected
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->genre)
                ->orWhere('genres.name', $request->genre);
            });
        }

        // Filter by search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        $sort = $request->get('sort'); // 'asc' or 'desc' for title
        if ($sort === 'asc' || $sort === 'desc') {
            $query->orderBy('title', $sort); // sort by title if requested
        } else {
            // Default: sort by rating descending
            $query->withAvg('ratings', 'rating')
                ->orderBy('ratings_avg_rating', 'desc');
        }

        $movies = $query->get();

        // For genre navigation
        $navGenres = Genre::orderBy('name')->pluck('name');

        return view('movies.index', compact('movies', 'navGenres'));
    }

    public function create()
    {
        // Robust admin check
        if (!$this->isAdmin()) {
            return redirect()->route('movies.index')
                ->with('error', 'You must be an admin to access this page.');
        }

        $genres = Genre::orderBy('name')->get();
        return view('movies.create', compact('genres'));
    }

    public function store(Request $request)
{
    if (!$this->isAdmin()) {
        return redirect()->route('movies.index')
            ->with('error', 'You must be an admin to create a movie.');
    }

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'short_description' => 'required|string|max:255',
        'long_description' => 'required|string|max:1000',
        'genre' => 'required|array|exists:genres,id', // Should be array since we use multiselect
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Prepare data for the Movie model, mapping long_description to the database's 'description' column
    $movieData = [
        'title' => $data['title'],
        'short_description' => $data['short_description'],
        'long_description' => $data['long_description'],
        'image' => $data['image'] ?? null,
    ];

    $movie = Movie::create($movieData);
    $movie->genres()->attach($data['genre']); // Attach handles array of IDs

    return redirect()->route('movies.index')
        ->with('success', 'Movie created successfully!');
    }

    public function show(Movie $movie)
    {
        $movie->load(['ratings' => function ($q) {
            $q->latest();
        }, 'genres']);

        return view('movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('movies.index')
                ->with('error', 'You must be an admin to edit this movie.');
        }

        $genres = Genre::orderBy('name')->get();
        return view('movies.edit', compact('movie', 'genres'));
    }

    public function update(Request $request, Movie $movie)
{
    if (!$this->isAdmin()) {
        return redirect()->route('movies.index')
            ->with('error', 'You must be an admin to update this movie.');
    }

    $data = $request->validate([
        'title' => 'required|string|max:255',
        'short_description' => 'required|string|max:255', 
        'long_description' => 'required|string|max:1000', 
        'genre' => 'required|array',
        //'rating' => 'required|numeric|min:0|max:5', Removed for consistency 
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $imageName;
    }

    $movieData = [
        'title' => $data['title'],
        'short_description' => $data['short_description'],
        'description' => $data['long_description'], // Maps long_description to DB column 'description'
        'image' => $data['image'] ?? $movie->image, // Retain existing image if new one isn't uploaded
    ];

    $movie->update($movieData); // Update using the correctly mapped array
    $movie->genres()->sync($data['genre']);

    return redirect()->route('movies.index')
        ->with('success', 'Movie updated successfully!');
}

    public function destroy(Movie $movie)
    {
        if (!$this->isAdmin()) {
            return redirect()->route('movies.index')
                ->with('error', 'You must be an admin to delete this movie.');
        }

        if ($movie->image && file_exists(public_path('images/' . $movie->image))) {
            unlink(public_path('images/' . $movie->image));
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Movie deleted successfully.');
    }

    // Simplified admin check
    private function isAdmin(): bool
    {
        $user = Auth::user();
        return $user && trim(strtolower($user->role)) === 'admin';
    }
}

