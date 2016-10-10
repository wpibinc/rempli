<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ListProduct extends Model
{
    protected $table = 'listproducts';
    
    protected $fillable = ['user_id', 'shop', 'product_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        $shop = $this->shop;
        return $this->belongsTo('App\\'.$this->shop.'Product', 'product_id', 'id');
    }
}
