<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Movie::query();

        // Filter by genre if provided
        if ($request->filled('genre')) {
            $query->where('genre', $request->genre);
        }

        // Search by title if provided
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Sorting
        if ($request->filled('sort')) {
            $direction = $request->sort === 'desc' ? 'desc' : 'asc';
            $query->orderBy('title', $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $movies = $query->get();

        $genres = Movie::select('genre')->distinct()->pluck('genre');

        return view('movies.index', compact('movies', 'genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($response = $this->adminOnly()) return $response;

        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($response = $this->adminOnly()) return $response;

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'rating' => 'required|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        Movie::create($data);

        return redirect()->route('movies.index')
                         ->with('success', 'Movie created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        if ($response = $this->adminOnly()) return $response;

        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        if ($response = $this->adminOnly()) return $response;

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
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

        return redirect()->route('movies.index')
                         ->with('success', 'Movie updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
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
     * Admin-only helper to check access.
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
