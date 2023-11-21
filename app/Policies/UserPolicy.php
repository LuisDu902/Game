<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy {

    public function edit(User $user, User $targetUser)
    {
        return $user->id === $targetUser->id;
    }

    public function updateStatus(User $user)
    {
        return $user->is_admin && !$user->is_banned;
    }

}