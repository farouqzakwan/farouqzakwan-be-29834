<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performers extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "performers";
    protected $guarded = [];

    /**
     * Get all of the movie_performers for the Performers
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movie_performers()
    {
        return $this->hasMany(MoviePerformers::class, 'performer_id', 'id');
    }
}
