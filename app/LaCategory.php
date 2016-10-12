<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\LaProduct;

class LaCategory extends Model
{
    public $shop = 'La';
    
    protected $table = 'la_categories';
    
    protected $fillable = ['name', 'link', 'parent_id', 'order'];
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_lacategory', 'lacategory_id', 'category_id');
    }
    
    public function products()
    {
        return $this->hasMany(LaProduct::class, 'la_category_id', 'id');
    }
}
