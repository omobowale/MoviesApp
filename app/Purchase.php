<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    
    protected $fillable = [
        'user_id', 'movie_id', 'date_purchased',
    ];
 
    //
    public function user(){

        return $this->belongsTo(User::class);

    }
}
