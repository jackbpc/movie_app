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

        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.name', $request->genre)
                  ->orWhere('genres.id', $request->genre);
            });
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('sort')) {
            $query->orderBy('title', $request->sort);
        }

        $movies = $query->get();
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
            'description' => 'required|string|max:1000',
            'genre' => 'required|exists:genres,id',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $movie = Movie::create($data);
        $movie->genres()->attach($data['genre']);

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
            'description' => 'required|string',
            'genre' => 'required|array',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($movie->image && file_exists(public_path('images/' . $movie->image))) {
                unlink(public_path('images/' . $movie->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $movie->update($data);
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

