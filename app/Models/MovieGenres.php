<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieGenres extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "movie_genres";
    protected $guarded = [];

    /**
     * Get the movie that owns the MovieGenres
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movies::class, 'movie_id', 'id');
    }

    /**
     * Get the genre that owns the MovieGenres
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function genre()
    {
        return $this->belongsTo(Genres::class, 'genre_id', 'id');
    }
}
