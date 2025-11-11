<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * Display a listing of movies.
     */
    public function index(Request $request)
    {
        $query = Movie::query()->with(['genres', 'ratings']); // eager load genres & ratings

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('id', $request->genre); // now filtering by genre ID
            });
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sort
        if ($request->filled('sort')) {
            $query->orderBy('title', $request->sort);
        }

        $movies = $query->get();

        // Genres for navbar / forms
        $navGenres = Genre::orderBy('name')->get();

        return view('movies.index', compact('movies', 'navGenres'));
    }

    /**
     * Show form to create a new movie.
     */
    public function create()
    {
        if ($response = $this->adminOnly()) return $response;

        $genres = Genre::orderBy('name')->get();
        return view('movies.create', compact('genres'));
    }

    /**
     * Store a newly created movie.
     */
    public function store(Request $request)
    {
        if ($response = $this->adminOnly()) return $response;

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'genre' => 'required|array', // array of genre IDs
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $movie = Movie::create($data);

        // Attach genres
        $movie->genres()->attach($data['genre']);

        return redirect()->route('movies.index')
            ->with('success', 'Movie created successfully!');
    }

    /**
     * Display a specific movie.
     */
    public function show(Movie $movie)
    {
        $movie->load(['ratings' => function ($q) {
            $q->latest();
        }, 'genres']);

        return view('movies.show', compact('movie'));
    }

    /**
     * Show form to edit a movie.
     */
    public function edit(Movie $movie)
    {
        if ($response = $this->adminOnly()) return $response;

        $genres = Genre::orderBy('name')->get();
        return view('movies.edit', compact('movie', 'genres'));
    }

    /**
     * Update a movie.
     */
    public function update(Request $request, Movie $movie)
    {
        if ($response = $this->adminOnly()) return $response;

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|array', // array of genre IDs
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($movie->image && file_exists(public_path('images/' . $movie->image))) {
                unlink(public_path('images/' . $movie->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $movie->update($data);

        // Sync genres
        $movie->genres()->sync($data['genre']);

        return redirect()->route('movies.index')
            ->with('success', 'Movie updated successfully!');
    }

    /**
     * Delete a movie.
     */
    public function destroy(Movie $movie)
    {
        if ($response = $this->adminOnly()) return $response;

        if ($movie->image && file_exists(public_path('images/' . $movie->image))) {
            unlink(public_path('images/' . $movie->image));
        }

        $movie->delete();

        return redirect()->route('movies.index')
            ->with('success', 'Movie deleted successfully.');
    }

    /**
     * Check admin access.
     */
    private function adminOnly()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('movies.index')
                ->with('error', 'You must be an admin to access this page.');
        }
        return null;
    }
}
