<?php

namespace App\Policies;

use App\AvProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvProductPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, AvProduct $item)
    {
        if ($user->username == 'admin') {
            return true;
        }
    }
}