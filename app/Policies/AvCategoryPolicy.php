<?php

namespace App\Policies;

use App\AvCategory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvCategoryPolicy
{

    use HandlesAuthorization;

    /**
     * @param User $user
     * @param string $ability
     *
     * @return bool
     */
    public function before(User $user, $ability, AvCategory $item)
    {
        if ($user->username == 'admin') {
            return true;
        }
    }
}