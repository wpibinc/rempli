<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;
use App\Order;
use App\Adress;
use App\Review;

class Subscription extends Authenticatable
{
    protected $table = 'subscriptions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'current_quantity', 'total_quantity', 'price', 'promocode', 'duration', 'start_promocode', 'promocode', 'auto_subscription'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array
     */
    public function getColumnNames()
    {
        return Schema::getColumnListing($this->table);
    }
}
