<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the thread.
     *
     * @param  \App\User  $user
     * @param  \App\User  $signedUser
     * @return mixed
     */
    public function update(User $user, User $signedUser)
    {
        return $signedUser->id == $user->id;
    }
}
