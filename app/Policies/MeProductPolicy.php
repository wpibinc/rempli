<?php

namespace App\Policies;

use App\MeProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeProductPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, MeProduct $item)
    {
        if ($user->username == 'admin') {
            return true;
        }
    }
}


