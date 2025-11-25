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
            $query->orderBy('title', $sort);
        } else {
            $query->withAvg('ratings', 'rating')
                  ->orderBy('ratings_avg_rating', 'desc');
        }

        $movies = $query->paginate(9)->withQueryString();
        $navGenres = Genre::orderBy('name')->pluck('name');

        return view('movies.index', compact('movies', 'navGenres'));
    }

    public function create()
    {
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
            'trailer_url' => 'nullable|url',
            'release_year' => 'nullable|integer',
            'age_rating' => 'nullable|string|max:10',
            'runtime' => 'nullable|string|max:10',
            'genre' => 'required|array|exists:genres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movieData = [
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'long_description' => $data['long_description'],
            'trailer_url' => $data['trailer_url'] ?? null,
            'release_year' => $data['release_year'] ?? null,
            'age_rating' => $data['age_rating'] ?? null,
            'runtime' => $data['runtime'] ?? null,
        ];

        // Handle poster upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $movieData['image'] = $filename;
        }

        $movie = Movie::create($movieData);
        $movie->genres()->attach($data['genre']);

        return redirect()->route('movies.index')
            ->with('success', 'Movie created successfully!');
    }

    public function show(Movie $movie)
    {
        $movie->load(['ratings' => fn($q) => $q->latest(), 'genres']);
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
            'trailer_url' => 'nullable|url',
            'release_year' => 'nullable|integer',
            'age_rating' => 'nullable|string|max:10',
            'runtime' => 'nullable|string|max:10',
            'genre' => 'required|array|exists:genres,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $movieData = [
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'long_description' => $data['long_description'],
            'trailer_url' => $data['trailer_url'] ?? $movie->trailer_url,
            'release_year' => $data['release_year'] ?? $movie->release_year,
            'age_rating' => $data['age_rating'] ?? $movie->age_rating,
            'runtime' => $data['runtime'] ?? $movie->runtime,
        ];

        // Handle poster upload and delete old image
        if ($request->hasFile('image')) {
            if ($movie->image && file_exists(public_path('images/' . $movie->image))) {
                unlink(public_path('images/' . $movie->image));
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $movieData['image'] = $filename;
        }

        $movie->update($movieData);
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

    private function isAdmin(): bool
    {
        $user = Auth::user();
        return $user && trim(strtolower($user->role)) === 'admin';
    }
}
