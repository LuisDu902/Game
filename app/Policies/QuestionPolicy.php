<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy {

    public function edit(User $user, Question $targetQuestion)
    {
        return $user->id === $targetQuestion->user_id;
    }

    public function vote(User $user, Question $targetQuestion)
    {
        return $user->id !== $targetQuestion->user_id;
    }
}