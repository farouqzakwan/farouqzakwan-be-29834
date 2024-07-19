<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\MoviePerformers;
use App\Models\Movies;
use App\Models\Performers;
use Illuminate\Http\Request;

class PerformerController extends Controller
{
    function search_performer(Request $request)
    {
        $performer = Performers::where('name',$request->performer_name)->pluck('id');

        if(empty($performer))
        {
            $response = [
                'error' => false,
                'message' => "Failed to find performer : $request->performer_name"
            ];

           return Response()->json($response,400);
        }

        $movie_performer = MoviePerformers::whereIn('performer_id',$performer)->pluck('movie_id');
        $movies = Movies::whereIn('id',$movie_performer)->with('movie_genres','movie_genres.genre')->get();

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
}
