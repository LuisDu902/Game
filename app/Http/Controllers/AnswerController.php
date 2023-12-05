<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'questionId' => 'required',
            'userId' => 'required',
        ]);
        $answer = Answer::createAnswerWithContent(
            $request->input('content'),
            $request->input('questionId'),
            $request->input('userId'),
        );
      
        return response()->json();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        
    }

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

        return response()->json(["success" => true, 'id' => $id], 200);
    }

    public function vote(Request $request, $answer_id)
    {        
        $reaction = $request->input('reaction');

        DB::table('vote')->insert([
            'date' => now(),
            'vote_type' => 'Answer_vote',
            'reaction' => $reaction,
            'answer_id' => $answer_id,
            'user_id' =>  Auth::user()->id,
        ]);

        return response()->json(['action'=> 'vote', 'id' => $answer_id]);
    }


    public function unvote(Request $request, $answer_id)
    {
        $user_id = Auth::user()->id;
        DB::table('vote')
            ->where('user_id', $user_id)
            ->where('answer_id', $answer_id)
            ->delete();
    
        return response()->json(['action' => 'unvote', 'id' => $answer_id]);
    }
}
