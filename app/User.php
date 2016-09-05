<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Order;
use App\Adress;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password' , 'fname', 'sname', 'phone'
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
}
