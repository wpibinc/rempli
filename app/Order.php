<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Order extends Model
{

    protected $table = 'orders';

    protected $guarded = ['id'];


    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
