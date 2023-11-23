<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy {

    public function edit(User $user, Answer $targetAnswer)
    {
        return $user->id === $targetAnswer->user_id;
    }


}