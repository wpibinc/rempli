<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvProduct extends Model
{
    protected $guarded =[];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }

    public function avcategory()
    {
        return $this->belongsTo(AvCategory::class, 'av_category_id','id');
    }

//    public function categories()
//    {
//        return $this->belongsToMany(Category::class, 'category_avcategory', 'avcategory_id', 'category_id');
//    }
}
