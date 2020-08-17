<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{

    protected $fillable = [
        'title', 'video', 'cover_image', 'actors', 'directors', 'duration', 'synopsis', 'genre_id', 'date_released', 'price'
    ];

    public function genre(){

        return $this->belongsTo('App\Genre');
    }
}
