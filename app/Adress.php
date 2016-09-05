<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Adress extends Model
{
    protected $table = 'adresses';
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
