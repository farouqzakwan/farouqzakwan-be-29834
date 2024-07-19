<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMovieRequest;
use App\Models\Genres;
use App\Models\MovieGenres;
use App\Models\MoviePerformers;
use App\Models\Movies;
use App\Models\Performers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MovieController extends Controller
{
    function add_movie(CreateMovieRequest $request)
    {
        $movie = Movies::create([
            'title'         => $request->title,
            'release'       => $request->release,
            'length'        => $request->length,
            'description'   => $request->description,
            'mpaa_rating'   => $request->mpaa_rating,
            'director'      => $request->director,
            'language'      => $request->language,
            'views'         => null,
        ]);

        $genres = $request->genre;
        $performers = $request->performer;

        foreach ($genres as $key => $genre)
        {
            $genre_collection = Genres::firstOrCreate([
                'genre' => strtolower($genre)
            ],[]);

            MovieGenres::create([
                'movie_id'  => $movie->id,
                'genre_id'  => $genre_collection->id
            ]);
        }

        foreach ($performers as $key => $performer)
        {
            $performer_collection = Performers::firstOrCreate([
                'name'  => strtolower($performer)
            ],[]);

            MoviePerformers::create([
                'movie_id'      => $movie->id,
                'performer_id'  => $performer_collection->id
            ]);
        }

        $response = [
            'success'   => true,
            'Message'   => "Successfully added movie $movie->title with Movie_ID $movie->id"
        ];

       return Response()->json($response);
    }

    function new_movie(Request $request)
    {
        $movies = Movies::where('release',$request->r_date)->with('movie_genres','movie_genres.genre')->get();
        $response['data'] = [];

        foreach ($movies as $key => $movie)
        {
            $genre = $movie->movie_genres->pluck('genre_id')->toArray();
            $genres = Genres::whereIn('id',$genre)->pluck('genre')->toArray();

            $obj =
            [
                'Movie_ID' => $movie->id,
                'Title' => $movie->title,
                'Genre' => $genres,
                'Duration' => $movie->movie_duration,
                'Views' => $movie->views,
                'Poster' => $movie->poster,
                'Overall_rating' => $movie->overall_rating,
                'Description' => $movie->description,
            ];

            $response['data'][] = $obj;
        }

        return Response()->json($response);

    }

    function genre(Request $request)
    {
        $genre = Genres::where('genre',strtolower($request->genre))->first();
        $movie_genres = MovieGenres::where('genre_id',$genre->id)->get()->pluck('movie_id')->toArray();
        $movies = Movies::whereIn('id',$movie_genres)->get();

        $response['data'] = [];

        foreach ($movies as $key => $movie)
        {
            $obj =
            [
                'Movie_ID' => $movie->id,
                'Title' => $movie->title,
                'Genre' => $genre->genre,
                'Duration' => $movie->movie_duration,
                'Views' => $movie->views,
                'Poster' => $movie->poster,
                'Overall_rating' => $movie->overall_rating,
                'Description' => $movie->description,
            ];

            $response['data'][] = $obj;
        }

        return Response()->json($response);
    }
}
