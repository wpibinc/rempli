<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MeProduct;

class MeCategory extends Model
{
    public $shop = 'Me';
    
    protected $table = 'me_categories';
    
    protected $fillable = ['name', 'link', 'parent_id', 'order'];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_mecategory', 'mecategory_id', 'category_id');
    }
    
    public function products()
    {
        return $this->hasMany(MeProduct::class, 'me_category_id', 'id');
    }
}
