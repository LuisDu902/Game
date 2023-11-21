<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = Question::where('is_public', true)
            ->orderBy('id', 'asc')
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
            $question['content'] = $question->latest_content(); 
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
      
        return view('pages.questions', ['questions' => $questions]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
