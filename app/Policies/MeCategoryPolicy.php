<?php

namespace App\Policies;

use App\MeCategory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeCategoryPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, MeCategory $item)
    {
        if ($user->username == 'admin') {
            return true;
        }
    }
}