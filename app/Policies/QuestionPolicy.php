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
      // Only a news owner or admin can delete it
      if($user->is_admin) return true;
      return $user->id == $news->user_id;
    }

}