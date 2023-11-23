<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Question;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class QuestionPolicy {

    use HandlesAuthorization;

    public function delete(User $user, Question $question)
    {
      if($user->is_admin) return true;
      return $user->id == $question->user_id;
    }

}