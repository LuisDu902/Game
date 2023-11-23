<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Answer;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AnswerPolicy {

    use HandlesAuthorization;

    public function delete(User $user, Answer $answer)
    {
      if($user->is_admin) return true;
      return $user->id == $answer->user_id;
    }

}