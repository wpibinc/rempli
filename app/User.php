<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Order;
use App\Adress;
use App\Review;
use App\ListProduct;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password' , 'fname', 'sname', 'phone', 'confirmation_code', 'free_delivery_manually'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
    public function adresses()
    {
        return $this->hasMany(Adress::class);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getInvoicesTotal()
    {
        $totalSum = 0;
        $invoices = $this->invoices()->where('is_paid', '0')
            ->where('last_pay_day', '<=' , Carbon::now()->addDay(1))->get();
        if(isset($invoices)) {
            foreach ($invoices as $invoice) {
                $totalSum += $invoice->price;
            }
        }
        return $totalSum;
    }
    
    public function listProducts()
    {
        return $this->hasMany(ListProduct::class);
    }
    
    public function isAdmin()
    {
        return $this->username == 'courier'||$this->username == 'admin'?true:false;
    }
}
