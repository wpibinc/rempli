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
        $shop = $this->order->shop;
        switch($shop){
            case 'Me': return $this->hasOne('App\MeProduct', 'id', 'objectId');
                break;
            case 'La': return $this->hasOne('App\LaProduct', 'id', 'objectId');
                break;
            default: return $this->hasOne('App\Product', 'id', 'objectId');
        }
    }

    public function avproduct()
    {
        return $this->hasOne('App\AvProduct', 'id', 'objectId');
    }
}
