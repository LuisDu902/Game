<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, $id)
    {

        $answer = Answer::find($id);
        $this->authorize('delete', $answer);

        $comments = $answer->comments;


        for($i=0; $i<count($comments); $i++){
            $comments[$i]->delete();
        }

        $answer->delete();

        return response()->json(["success" => true], 200);
    }
}
