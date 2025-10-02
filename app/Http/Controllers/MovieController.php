<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;

class MovieController extends Controller
{
    public function home(Request $request)
    {
        $query = $request->input('search');

        if ($query) {
            $movies = Movie::where('title', 'like', "%{$query}%")->get();
        } else {
            $movies = Movie::all();
        }

        return view('home', compact('movies'));
    }

    // แสดงรายการหนังทั้งหมด
    public function index()
    {
        $movies = Movie::with('categories')->get();
        return view('movies.index', compact('movies'));
    }

    // แสดงรายละเอียดหนัง
    public function show($id)
    {
        $movie = Movie::with(['comments.user', 'categories'])->findOrFail($id);
        return view('movies.show', compact('movie'));
    }

    // แสดงหน้าตัวอย่างหนัง
    public function trailer($id)
    {
        $movie = Movie::findOrFail($id);
        $youtubeId = $this->getYouTubeId($movie->trailer_url);
        return view('movies.trailer', compact('movie', 'youtubeId'));
    }

    /**
     * Extracts the YouTube video ID from a given URL.
     *
     * @param string|null $url
     * @return string|null
     */
    private function getYouTubeId($url): ?string
    {
        if (!$url) {
            return null;
        }
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        return $match[1] ?? null;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $movies = Movie::where('title', 'like', "%{$query}%")->get();
        return response()->json($movies);
    }
}
