<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvCategory extends Model
{
    protected $guarded = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_avcategory', 'avcategory_id', 'category_id');
    }

    public function getFullNameAttribute()
    {
        if ($this->subtitle == '')
            return $this->name;
        else
            return $this->name .' '. $this->subtitle;
    }
    
    public function products()
    {
        return $this->hasMany('\App\AvProduct', 'av_category_id', 'id');
    }
}
