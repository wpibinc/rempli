<?php

namespace App\Policies;

use App\Order2;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Order2Policy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, Order2 $item)
    {
        if ($user->username == 'courier') {
            return true;
        }
    }
}