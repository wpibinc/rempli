<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AvCategory;
use App\LaCategories;

class Category extends Model
{
    protected $guarded = ['id'];

    public function avcategories()
    {
        return $this->belongsToMany(AvCategory::class, 'category_avcategory', 'category_id', 'avcategory_id');
    }
    
    public function products()
    {
        return $this->hasMany('\App\Product', 'category_id', 'category_id');
    }
    
    public function avProducts()
    {
        return $this->hasMany('\App\AvProduct', 'category_id', 'id');
    }
    
    public function lacategories()
    {
        return $this->belongsToMany(LaCategory::class, 'category_lacategory', 'category_id', 'lacategory_id');
    }

    public function mecategories()
    {
        return $this->belongsToMany(MeCategory::class, 'category_mecategory', 'category_id', 'mecategory_id');
    }
//    public function getAvcategoriesAttribute()
//    {
//       // dd('lol');
//    }

//    public function setAvcategoriesAttribute($categories)
//    {
//
//        dd($categories);
//
//        $this->companies()->detach();
//        if (! $companies) {
//            return;
//        }
//        if (! $this->exists) {
//            $this->save();
//        }
//        $this->companies()->attach($companies);
//    }

    
}
