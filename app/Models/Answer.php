<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Answer extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'answer';

    /**
     * Get the question.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

      /**
     * Get the user that created the question.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the latest answer content.
     */
    public function latest_content()
    {
        return DB::table('version_content')
        ->select('content')
        ->where('answer_id', $this->id)
        ->orderByDesc('date') 
        ->limit(1)
        ->value('content');
    }

    public static function createAnswerWithContent($content, $questionId, $userId){
        $answer = new static;

        $answer->user_id = $userId;
        $answer->question_id = $questionId;
        $answer->top_answer = false;
        $answer->is_public = true; 
        $answer->votes = 0;

        $answer->save();

        $answerId = $answer->id;
    


        DB::table('answer')->insert([
            'user_id' => $userId,
            'question_id' => $questionId,
            'is_public' => true,
            'top_answer' => false,
            'votes' => 0,
        ]);

        DB::table('version_content')->insert([
            'date' => now(),
            'content' => $content,
            'content_type' => 'Answer_content',
            'question_id' => null,
            'answer_id' => $answerId,
            'comment_id' => null,
        ]);


        return $answer;
    }

}

