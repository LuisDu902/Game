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
        $answer = Answer::findOrFail($id);
        $this->authorize('updateStatus', [Auth::user(), $answer]);
        $request->validate([
            'content' => 'required|string'
        ]);

        DB::table('version_content')->insert([
            'date' => now(),
            'content' => $request->input('content'),
            'content_type' => 'Answer_content',
            'question_id' => null,
            'answer_id' => $id,
            'comment_id' => null,
        ]);

        return response()->json(['message' => 'Question updated successfully']);
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

        return response()->json(["success" => true], 200);
    }
}
