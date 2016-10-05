<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Order;
use App\Adress;
use App\Review;

class Subscription extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'quantity', 'price'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function adresses()
    {
        return $this->hasMany(Adress::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
