<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Theaters extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "theaters";
    protected $guarded = [];

    /**
     * Get all of the movie_theaters for the Theaters
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movie_theaters()
    {
        return $this->hasMany(MovieTheaters::class, 'theater_id', 'id');
    }
}
