<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{

    protected $guarded = ['id'];


    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'objectId');
    }

    public function avproduct()
    {
        return $this->hasOne('App\AvProduct', 'id', 'objectId');
    }
}
