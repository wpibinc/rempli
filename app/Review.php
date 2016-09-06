<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
