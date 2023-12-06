<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\VersionContent;
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
            'question_id' => 'required'
        ]);
        
        $answer = Answer::create([
            'user_id' => Auth::id(),
            'question_id' => $request->input('question_id'),
        ]);
      
        $answer->votes = 0;

        VersionContent::create([
            'date' => now(),
            'content' => $request->input('content'),
            'content_type' => 'Answer_content',
            'answer_id' => $answer->id
        ]);

        return view('partials._answer', compact('answer'))->render();
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
