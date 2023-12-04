<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use App\Models\Answer;
use App\Models\VersionContent;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\GameCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::where('is_public', true)
            ->orderBy('create_date', 'desc')
            ->paginate(10);
        return view('pages.questions', ['questions' => $questions]);
    }

    public function list(Request $request) 
    {
        $criteria = $request->input('criteria', '');
        $query = Question::where('is_public', true);
    
        switch ($criteria) {
            case 'popular':
                $query->orderBy('votes', 'desc');
                break;
            case 'unanswered':
                $query->where('is_solved', false)
                    ->orderBy('create_date', 'desc');
                break;
            default:
                $query->orderBy('create_date', 'desc');
                break;
        }
        
        $questions = $query->paginate(10);
        
        $questions->getCollection()->transform(function ($question) {
            $question['time'] = $question->timeDifference();
            $question['answers'] = $question->answers; 
            $question['content'] = $question->latestContent(); 
            $question['creator'] = $question->creator; 
            return $question;
        });

        $questions->appends([
           'criteria' => $criteria
        ]);

        return view('partials._questions', compact('questions'))->render();
    }


    public function search(Request $request)
    {
        $query = $request->input('query');
      
        $questions = Question::whereRaw('tsvectors @@ plainto_tsquery(?)', [$query])
            ->orderByRaw('ts_rank(tsvectors, plainto_tsquery(?)) DESC', [$query])
            ->paginate(10);
      
        return view('pages.search', ['questions' => $questions]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = GameCategory::all();
        $tags = Tag::all();
        return view('pages.newQuestion', ['categories' => $categories, 'tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:256',
            'content' => 'required',
            'game_id' => 'nullable|exists:game,id'
        ]);

        $game_id = $request->input('game_id');

        $question = Question::create([
          'title' => $request->input('title'),
          'user_id' => Auth::id(),
          'create_date' => now(),
          'game_id' => ($game_id == 0 ? NULL : $game_id),
        ]);

        VersionContent::create([
            'date' => now(),
            'content' => $request->input('content'),
            'content_type' => 'Question_content',
            'question_id' => $question->id
        ]);
        
        if ($request->tags !== "0") {
            $tags = explode(',', $request->tags);
        
            foreach ($tags as $tag) {
                DB::table('question_tag')->insert([
                    'question_id' => $question->id,
                    'tag_id' => $tag
                ]);
            }
        }
        
        return response()->json(['id' => $question->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);
        return view('pages.questionDetail', ['question' => $question]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $this->authorize('edit', [Auth::user(), $question]);
        
        $request->validate([
            'content' => 'required|string',
            'title' => 'required|string',
        ]);
        
        $question->title = $request->input('title');

        $question->save();

        DB::table('version_content')->insert([
            'date' => now(),
            'content' => $request->input('content'),
            'content_type' => 'Question_content',
            'question_id' => $id,
            'answer_id' => null,
            'comment_id' => null,
        ]);

        return response()->json(['message' => 'Question updated successfully']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, $id)
    {

        $question = Question::find($id);
        $this->authorize('delete', $question);

        $answers = $question->answers;

        for($i=0; $i<count($answers); $i++){
            $answers[$i]->delete();
        }

        $question->delete();

        return redirect('/questions')->with('delete', 'Question successfully deleted!');
    }

    
    public function vote(Request $request, $question_id)
    {
        $question = Question::findOrFail($question_id);
        
        $reaction = $request->input('reaction');

        DB::table('vote')->insert([
            'date' => now(),
            'vote_type' => 'Question_vote',
            'reaction' => $reaction,
            'question_id' => $question_id,
            'user_id' =>  Auth::user()->id,
        ]);

        return response()->json(['action'=> 'vote']);
    }


    public function unvote(Request $request, $question_id)
    {
        $user_id = Auth::user()->id;
    
        DB::table('vote')
            ->where('user_id', $user_id)
            ->where('question_id', $question_id)
            ->delete();
    
        return response()->json(['action' => 'unvote']);
    }
    

    public function hasVoted($questionId, $userId) {

        $hasVoted = DB::table('vote')
            ->where('vote_type', 'Question_vote')
            ->where('question_id', $questionId)
            ->where('user_id', $userId)
            ->exists();

        return response()->json(['hasVoted' => $hasVoted]);
    }


    public function store_comment(Request $request)
    {

        $request->validate([
            'commentario' => 'required|string',
            'answerId' => 'required',
            'userId' => 'required',
        ]);

        $comment = Comment::createCommentWithContent(
            $request->input('commentario'),
            $request->input('answerId'),
            $request->input('userId'),
        );
    
        return redirect()->route('question', ['id' => $request->input('questionId')]);
    }



}
