<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Question extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'question';

    protected $fillable = [
        'user_id',
        'create_date',
        'title',
    ];

    /**
     * Get the user that created the question.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the asnwers to the question.
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }
    /**
     * Get the latest question content.
     */
    public function latest_content()
    {
        return DB::table('version_content')
        ->select('content')
        ->where('question_id', $this->id)
        ->orderByDesc('date') 
        ->limit(1)
        ->value('content');
    }

    public function timeDifference() {
        $now = now();
        $createdAt = $this->create_date;
        return $now->diffForHumans($createdAt, true);
    }

    public static function createQuestionWithContent($title, $content, $game_id)
    {
        $question = new static;

        $question->user_id = Auth::id();
        $question->create_date = now();
        $question->title = $title;
        $question->game_id = $game_id;
        $question->is_solved = false;
        $question->is_public = true; 
        $question->nr_views = 0;
        $question->votes = 0;

        $question->save();

        DB::table('version_content')->insert([
            'question_id' => $question->id,
            'content' => $content,
            'date' => now(),
            'content_type' => 'Question_content',
        ]);

        return $question;
    }

}
