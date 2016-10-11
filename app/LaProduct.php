<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\LaCategory;

class LaProduct extends Model
{
    protected $primaryKey = 'articul';
    
    protected $table = 'la_products';
    
    protected $guarded = ['created_at', 'updated_at'];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id','id');
    }
    
    public function laCategory()
    {
        return $this->belongsTo(LaCategory::class, 'la_category_id','id');
    }
}
