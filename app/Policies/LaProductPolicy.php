<?php

namespace App\Policies;

use App\LaProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaProductPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, LaProduct $item)
    {
        if ($user->username == 'admin') {
            return true;
        }
    }
}

