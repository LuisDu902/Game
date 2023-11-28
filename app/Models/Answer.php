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

    protected $fillable = [
        'user_id',
        'question_id',
        'is_public',
    ];

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


    public function comments()
    {
        return $this->hasMany(Comment::class, 'answer_id');
    }

    public function versionContent(): HasMany 
    {
        return $this->hasMany(VersionContent::class);
    }

    /**
     * Get the latest answer content.
     */
    public function latestContent()
    {
        return $this->versionContent()
        ->orderByDesc('date')
        ->first()
        ->content; 
    }


    public function createDate()
    {
        return $this->versionContent()
        ->orderBy('date')
        ->first()
        ->date; 
    }

    public function lastDate()
    {
        return $this->versionContent()
        ->orderByDesc('date')
        ->first()
        ->date; 
    }

    public function timeDifference() {
        $now = now();
        $createdAt = $this->createDate();
        return $now->diffForHumans($createdAt, true);
    }

    public function lastModification() {
        $now = now();
        $modifiedAt = $this->lastDate();
        return $now->diffForHumans($modifiedAt, true);
    }

    public static function createAnswerWithContent($content, $questionId, $userId){
        $answer = new static;

        $answer->user_id = (int)$userId;
        $answer->question_id = $questionId;

        $answer->save();

        $answerId = $answer->id;


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
