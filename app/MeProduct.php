<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MeCategory;

class MeProduct extends Model
{
    public $shop = 'Me';
    
    protected $table = 'me_products';
    
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    public function meCategory()
    {
        return $this->belongsTo(MeCategory::class, 'me_category_id', 'id');
    }
    
    public function category()
    {
        return $this->meCategory->categories->first();
    }
}
