<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genres extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "genres";
    protected $guarded = [];

    /**
     * Get all of the movie_genres for the Genres
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movie_genres()
    {
        return $this->hasMany(MovieGenres::class, 'genre_id', 'id');
    }
}
