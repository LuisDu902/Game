<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'question_tag', 'question_id', 'tag_id');
    }
    
    public function versionContent(): HasMany 
    {
        return $this->hasMany(VersionContent::class);
    }

    /**
     * Get the latest question content.
     */
    public function latestContent()
    {
        return $this->versionContent()
        ->orderByDesc('date')
        ->first()
        ->content; 
    }

    public function topAnswer(){
        return $this->answers()
        ->orderByDesc('votes')
        ->first();
    }

    public function otherAnswers(){
        $topAnswerId = $this->topAnswer()->id ?? null;

        return $this->answers()
            ->when($topAnswerId, function ($query) use ($topAnswerId) {
                return $query->where('id', '!=', $topAnswerId);
            })->orderByDesc('votes')
            ->get();
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

        $question->save();

        DB::table('version_content')->insert([
            'question_id' => $question->id,
            'content' => $content,
            'date' => now(),
            'content_type' => 'Question_content',
        ]);

        return $question;
    }

    public function lastDate()
    {
        return $this->versionContent()
        ->orderByDesc('date')
        ->first()
        ->date; 
    }

    public function lastModification() {
        $now = now();
        $modifiedAt = $this->lastDate();
        return $now->diffForHumans($modifiedAt, true);
    }

    public function history() {

    }

}
