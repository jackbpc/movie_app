<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all movies from the database
        $movies = Movie::all();
        // Return the view with movies data
        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate input
    $request->validate([
        'title' => 'required',
        'description' => 'required|max:500',
        'genre' => 'required',
        'rating' => 'required|numeric|min:0|max:10',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Check if the image is uploaded and handle it
    if ($request->hasFile('image')) {

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/movies'), $imageName);
    }
    // Create a movie record in the database
    Movie::create([
        'title' => $request->title,
        'description' => $request->description,
        'genre' => $request->genre,
        'rating' => $request->rating,
        'image' => $imageName, // Store the `image` URL in the DB
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Redirect to the index page with a success message
    return to_route('movies.index')->with('success', 'Movie created successfully!');
}


    /**
     * Display the specified resource.
     */
    // Show a single movie's details.
    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        return view('movies.edit', compact('movie'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        // Validate
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'rating' => 'required|numeric|min:0|max:10',
            'image' => 'nullable|image|max:2048', // optional file
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // generate a unique filename (movie id + timestamp)
            $filename = $movie->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            // move file to public/images
            $file->move(public_path('images'), $filename);

            // store filename in DB
            $data['image'] = $filename;
        }

        // Update movie
        $movie->update($data);

        // Redirect to movies index with success message
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
    
}
