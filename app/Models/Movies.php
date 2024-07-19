<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movies extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "movies";
    protected $guarded = [];

    /**
     * Get all of the movie_theaters for the Movies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movie_theaters()
    {
        return $this->hasMany(MovieTheaters::class, 'movie_id', 'id');
    }

    /**
     * Get all of the movie_genres for the Movies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movie_genres()
    {
        return $this->hasMany(MovieGenres::class, 'movie_id', 'id');
    }

    /**
     * Get all of the movie_performers for the Movies
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movie_performers()
    {
        return $this->hasMany(MoviePerformers::class, 'movie_id', 'id');
    }


    function getOverallRatingAttribute()
    {
        $sum_rating = Ratings::where('movie_id',$this->id)->sum('rating');
        $count_rating = Ratings::where('movie_id',$this->id)->count('id');

        if(empty($sum_rating) && empty($count_rating))
        {
            return 0;
        }


        return $sum_rating / $count_rating;
    }

    function getMovieDurationAttribute()
    {
        if ($this->length < 60) {
            return str_pad($this->length,2,'0',STR_PAD_LEFT) . ' minutes';
        }

        $hours = intdiv($this->length, 60);
        $minutes = $this->length % 60;

        return $hours . ' hours ' . ($minutes > 0 ? str_pad($minutes,2,'0',STR_PAD_LEFT)  . ' minutes' : '');
    }
}
