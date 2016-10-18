<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Schema;

class Invoice extends Authenticatable
{
    protected $table = 'invoices';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'order_id', 'subscription_id', 'title', 'price', 'is_paid', 'last_pay_day', 'extra_deliveries'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
    /**
     * @return array
     */
    public function getColumnNames()
    {
        return Schema::getColumnListing($this->table);
    }
}
