<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieTheaters extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "movie_theaters";
    protected $guarded = [];

    /**
     * Get the movie that owns the MovieTheaters
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movies::class, 'movie_id', 'id');
    }

    /**
     * Get the theater that owns the MovieTheaters
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function theater()
    {
        return $this->belongsTo(Theaters::class, 'theater_id', 'id');
    }
}
