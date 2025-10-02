<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Movie $movie)
    {
        auth()->user()->favoriteMovies()->attach($movie->id);
        return back()->with('success', 'Movie added to favorites!');
    }

    public function destroy(Movie $movie)
    {
        auth()->user()->favoriteMovies()->detach($movie->id);
        return back()->with('success', 'Movie removed from favorites!');
    }

    public function index()
    {
        $movies = auth()->user()->favoriteMovies()->get();
        return view('favorites.index', compact('movies'));
    }
}