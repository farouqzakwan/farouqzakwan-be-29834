<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MoviePerformers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "movie_performers";
    protected $guarded = [];

    /**
     * Get the movie that owns the MoviePerformers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movies::class, 'movie_id', 'id');
    }

    /**
     * Get the performer that owns the MoviePerformers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function performer()
    {
        return $this->belongsTo(Performers::class, 'performer_id', 'id');
    }
}
