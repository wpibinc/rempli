<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;
use App\Order;
use App\Adress;
use App\Review;

class LongPromocode extends Authenticatable
{
    protected $table = 'long_promocodes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subscription_id', 'used_per_month', 'end_subscription'
    ];
    /**
     * @return array
     */
    public function getColumnNames()
    {
        return Schema::getColumnListing($this->table);
    }
}
