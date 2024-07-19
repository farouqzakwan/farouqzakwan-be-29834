<?php

use App\Http\Controllers\API\V1\MovieController;
use App\Http\Controllers\API\V1\RatingController;
use App\Http\Controllers\MovieTheaterController;
use App\Http\Controllers\PerformerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/genre',                            [MovieController::class,'genre'])->name('genre.API.GET');
Route::post('/add_movie',                       [MovieController::class,'add_movie'])->name('add_movie.API.POST');
Route::post('/give_rating',                     [RatingController::class,'give_rating'])->name('give_rating.API.POST');
Route::get('/timeslot',                         [MovieTheaterController::class,'timeslot'])->name('timeslot.API.GET');
Route::get('/specific_movie_theater',           [MovieTheaterController::class,'plays'])->name('specific_movie_theater.API.GET');
Route::get('/search_performer',                 [PerformerController::class,'search_performer'])->name('search_performer.API.GET');
Route::get('/new_movies',                       [MovieController::class,'new_movie'])->name('new_movie.API.GET');
