<?php

namespace App\Policies;

use App\LaCategory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaCategoryPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, LaCategory $item)
    {
        if ($user->username == 'admin') {
            return true;
        }
    }
}

