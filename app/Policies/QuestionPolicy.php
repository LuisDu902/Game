<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy {

    use HandlesAuthorization;

    public function delete(User $user, Question $question)
    {
      if($user->is_admin) return true;
      return $user->id == $question->user_id;
    }

    public function view(User $user, Question $question) {
        if ($question->is_public) return true;
        if ($user->is_admin) return true;
        return $user->id == $question->user_id;
    }

    public function edit(User $user, Question $targetQuestion)
    {
        return $user->id === $targetQuestion->user_id;
    }

    public function vote(User $user, Question $targetQuestion)
    {
        return $user->id !== $targetQuestion->user_id;
    }
}