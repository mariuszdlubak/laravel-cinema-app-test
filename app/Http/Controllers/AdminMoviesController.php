<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class AdminMoviesController extends Controller
{
    public function index()
    {
        return view(
            'admin.movie.index',
            [
                'movies' => Movie::orderBy('id', 'DESC')->paginate(25)
            ]
        );
    }

    public function create()
    {
        return view('admin.movie.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banner' => 'required|file|mimes:png,jpg,jpeg,webp|max:2048',
            'icon' => 'required|file|mimes:png,jpg,jpeg,webp|max:2048',
            'title' => 'required|string|min:1|max:255',
            'description' => 'required|string|min:80',
            'fun_fact' => 'required|string|min:20',
            'release_date' => 'required|date',
            'duration' => 'required|numeric|min:1|max:999',
            'genre' => 'required|string|min:1|max:255',
            'cast' => 'required|string|min:1|max:255',
            'director' => 'required|string|min:1|max:255',
            'production' => 'required|string|min:1|max:255',
            'original_language' => 'required|string|min:1|max:255',
            'age_restrictions' => 'required|numeric|min:1|max:18',
            'trailer' => 'required|string|min:10'
        ]);

        $pattern = '/<iframe.*?src="(.*?)".*?>/i';
        preg_match($pattern, $validatedData['trailer'], $matches);

        $trailerPath = '';

        if (isset($matches[1])) {
            $trailerPath = $matches[1];
        } else {
            return redirect()->back()->withErrors(['trailer' => 'Incorrect trailer path.'])->withInput();
        }

        $bannerFile = $request->file('banner');
        $bannerPath = $bannerFile->store('movies', 'public');

        $iconFile = $request->file('icon');
        $iconPath = $iconFile->store('movies', 'public');

        $movie = new Movie([
            'title' => $validatedData['title'],
            'release_date' => $validatedData['release_date'],
            'duration' => $validatedData['duration'],
            'description' => $validatedData['description'],
            'fun_fact' => $validatedData['fun_fact'],
            'genre' => $validatedData['genre'],
            'cast' => $validatedData['cast'],
            'director' => $validatedData['director'],
            'production' => $validatedData['production'],
            'original_language' => $validatedData['original_language'],
            'age_restrictions' => $validatedData['age_restrictions'],
            'icon_path' => $iconPath,
            'baner_path' => $bannerPath,
            'trailer_path' => $trailerPath
        ]);
        $movie->save();

        return redirect()->route('admin.movies.index', $movie)
            ->with('success', 'Movie added successfully.');
    }

    public function show(Movie $movie)
    {
        return redirect()->route('admin.movies.edit', $movie);
    }

    public function edit(Movie $movie)
    {
        $trailer = '<iframe';
        $trailer .= "\n\tclass=\"w-full aspect-video rounded-lg overflow-hidden\"";
        $trailer .= "\n\tsrc=\"" . $movie->trailer_path . "\"";
        $trailer .= "\n\ttitle=\"YouTube video player\"";
        $trailer .= "\n\tframeborder=\"0\"";
        $trailer .= "\n\tallow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" allowfullscreen";
        $trailer .= "\n></iframe>";

        return view(
            'admin.movie.edit',
            [
                'movie' => $movie,
                'trailer' => $trailer
            ]
        );
    }

    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate([
            'banner' => 'sometimes|file|mimes:png,jpg,jpeg,webp|max:2048',
            'icon' => 'sometimes|file|mimes:png,jpg,jpeg,webp|max:2048',
            'title' => 'sometimes|string|min:1|max:255',
            'description' => 'sometimes|string|min:80',
            'fun_fact' => 'sometimes|string|min:20',
            'release_date' => 'sometimes|date',
            'duration' => 'sometimes|numeric|min:1|max:999',
            'genre' => 'sometimes|string|min:1|max:255',
            'cast' => 'sometimes|string|min:1|max:255',
            'director' => 'sometimes|string|min:1|max:255',
            'production' => 'sometimes|string|min:1|max:255',
            'original_language' => 'sometimes|string|min:1|max:255',
            'age_restrictions' => 'sometimes|numeric|min:1|max:18',
            'trailer' => 'sometimes|string|min:10'
        ]);

        $pattern = '/<iframe.*?src="(.*?)".*?>/i';
        preg_match($pattern, $validatedData['trailer'], $matches);

        $trailerPath = $movie->trailer_path;

        if (isset($matches[1])) {
            $trailerPath = $matches[1];
        }

        $bannerFile = $request->file('banner');
        $bannerPath = $movie->baner_path;

        if($bannerFile) {
            $bannerPath = $bannerFile->store('movies', 'public');
        }

        $iconFile = $request->file('icon');
        $iconPath = $movie->icon_path;

        if($iconFile) {
            $iconPath = $iconFile->store('movies', 'public');
        }

        $movie->update([
            'title' => $validatedData['title'],
            'release_date' => $validatedData['release_date'],
            'duration' => $validatedData['duration'],
            'description' => $validatedData['description'],
            'fun_fact' => $validatedData['fun_fact'],
            'genre' => $validatedData['genre'],
            'cast' => $validatedData['cast'],
            'director' => $validatedData['director'],
            'production' => $validatedData['production'],
            'original_language' => $validatedData['original_language'],
            'age_restrictions' => $validatedData['age_restrictions'],
            'icon_path' => $iconPath,
            'baner_path' => $bannerPath,
            'trailer_path' => $trailerPath
        ]);

        return redirect()->route('admin.movies.index', $movie)
            ->with('success', 'Movie updated successfully.');
    }
}
