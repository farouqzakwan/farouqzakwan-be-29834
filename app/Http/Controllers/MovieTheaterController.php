<?php

namespace App\Http\Controllers;

use App\Models\Genres;
use App\Models\Movies;
use App\Models\MovieTheaters;
use App\Models\Theaters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class MovieTheaterController extends Controller
{
    function timeslot(Request $request)
    {
        $time_start = $request->time_start;
        $time_end = $request->time_end;

        $theater = Theaters::where('name',$request->theater_name)->first();

        $movie_theaters = MovieTheaters::where('time_start','<=',$time_end)
                            ->where('time_end','>=',$time_start)
                            ->where('id',$theater->id)
                            ->with('movie','movie.movie_genres','movie.movie_genres.genre','theater')
                            ->get();
        $response['data'] = [];

        foreach ($movie_theaters as $key => $theater)
        {
            $genre = $theater->movie->movie_genres->pluck('genre_id')->toArray();
            $genres = Genres::whereIn('id',$genre)->pluck('genre')->toArray();

                $obj =
                [
                    'Movie_ID' => $theater->movie->id,
                    'Title' => $theater->movie->title,
                    'Genre' => $genres,
                    'Duration' => $theater->movie->movie_duration,
                    'Views' => $theater->movie->views,
                    'Poster' => $theater->movie->poster,
                    'Overall_rating' => $theater->movie->overall_rating,
                    'Description' => $theater->movie->description,
                    'Start_time' => $theater->time_start ? $theater->time_start : null,
                    'End_time' => $theater->time_end ? $theater->time_end : null,
                    'Theater_room_no' => $theater->theater->id,
                ];

            $response['data'][] = $obj;

        }

        return Response()->json($response);

    }

    function plays(Request $request)
    {
        $theater = Theaters::where('name',$request->theater_name)->first();
        if(empty($theater))
        {
            $response = [
                'error' => false,
                'message' => "Failed to find theater : $request->theater_name"
            ];

           return Response()->json($response,400);
        }

        $movie_theaters = MovieTheaters::where('theater_id',$theater->id)
                        ->whereDate('time_start',$request->d_date)
                        ->get()
                        ->pluck('movie_id')
                        ->toArray();

        $movies = Movies::whereIn('id',$movie_theaters)->with('movie_genres','movie_genres.genre')->get();

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
