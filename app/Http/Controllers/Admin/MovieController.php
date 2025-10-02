<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;

class MovieController extends Controller
{
    public function index() {
        $movies = Movie::all();
        return view('admin.movies.index', compact('movies'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.movies.create', compact('categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_image_url' => 'nullable|string',
            'trailer_url' => 'nullable|string|url',
            'release_date' => 'nullable|date',
            'categories' => 'array',
        ]);

        $movie = Movie::create($request->only(['title', 'description', 'poster_image_url', 'trailer_url', 'release_date']));
        $movie->categories()->sync($request->categories);

        return redirect()->route('admin.movies.index')->with('success', 'Movie created successfully.');
    }

    public function edit($id) {
        $movie = Movie::findOrFail($id);
        $categories = Category::all();
        return view('admin.movies.edit', compact('movie','categories'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster_image_url' => 'nullable|string',
            'trailer_url' => 'nullable|string|url',
            'release_date' => 'nullable|date',
            'categories' => 'array',
        ]);

        $movie = Movie::findOrFail($id);
        $movie->update($request->only(['title', 'description', 'poster_image_url', 'trailer_url', 'release_date']));
        $movie->categories()->sync($request->categories);

        return redirect()->route('admin.movies.index')->with('success', 'Movie updated successfully.');
    }

    public function destroy($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return redirect()->route('admin.movies.index')->with('success', 'Movie deleted successfully.');
    }
}
