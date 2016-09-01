<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class Product extends Model
{

    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','category_id');
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

}
