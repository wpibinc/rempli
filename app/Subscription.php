<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;
use App\Invoice;

class Subscription extends Authenticatable
{
    protected $table = 'subscriptions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'current_quantity', 'total_quantity', 'price', 'promocode', 'duration', 'start_promocode', 'promocode', 'auto_subscription', 'is_free', 'extra_deliveries', 'extra_deliveries_price'
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
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
