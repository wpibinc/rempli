<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
    
    public function avCategory()
    {
        return $this->belongsToMany('\App\AvCategory', 'category_avcategory', 'avcategory_id', 'category_id');
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
