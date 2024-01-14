<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieType;
use Illuminate\Http\Request;

class AdminTypesController extends Controller
{
    public function create(Movie $movie)
    {
        return view(
            'admin.movie.types.create',
            [
                'movie' => $movie
            ]
        );
    }

    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'type' => 'required',
            'language' => 'required'
        ]);

        $movie->movieTypes()->create([
            'type' => $request['type'],
            'language' => $request['language']
        ]);

        return redirect()->route('admin.movies.schedules.index', $movie)->with('success', 'New type added successfully');
    }

    public function edit(Movie $movie, MovieType $type)
    {
        return view(
            'admin.movie.types.edit',
            [
                'movie' => $movie,
                'type' => $type
            ]
        );
    }

    public function update(Request $request, Movie $movie, MovieType $type)
    {
        $request->validate([
            'type' => 'required',
            'language' => 'required'
        ]);

        $type->update([
            'type' => $request['type'],
            'language' => $request['language']
        ]);

        return redirect()->route('admin.movies.schedules.index', $movie)->with('success', 'Type updated successfully');
    }
}
