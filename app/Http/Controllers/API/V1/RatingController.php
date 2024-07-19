<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiveRatingRequest;
use App\Models\Movies;
use App\Models\Ratings;

class RatingController extends Controller
{
    function give_rating(GiveRatingRequest $request)
    {
        $movie = Movies::where('title',$request->movie_title)->first();

        if(empty($movie))
        {
            $response = [
                'error' => false,
                'message' => "Failed added review for the $request->movie_title by user: $request->username"
            ];

           return Response()->json($response,400);
        }

        Ratings::create([
            'movie_id'          => $movie->id,
            'username'          => $request->username,
            'rating'            => $request->rating,
            'description'       =>$request->r_description,
        ]);

        $response = [
            'success' => true,
            'message' => "Successfully added review for the $movie->title by user: $request->username"
        ];

       return Response()->json($response);
    }
}
