<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        \App\Category::class => \App\Policies\CategoryPolicy::class,
        \App\Product::class => \App\Policies\ProductPolicy::class,
        \App\Order::class => \App\Policies\OrderPolicy::class,
        \App\Order2::class => \App\Policies\Order2Policy::class,
        \App\AvCategory::class => \App\Policies\AvCategoryPolicy::class,
        \App\AvProduct::class => \App\Policies\AvProductPolicy::class,
        \App\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $gate->define('show',function ($user){
            //dd($user->username);
            return $user->username=='admin';
        });
    }
}
