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

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
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

    public function create_date()
    {
        return DB::table('version_content')
        ->select('date')
        ->where('answer_id', $this->id)
        ->orderBy('date') 
        ->limit(1)
        ->value('date');
    }

    public function last_date()
    {
        return DB::table('version_content')
        ->select('date')
        ->where('answer_id', $this->id)
        ->orderByDesc('date') 
        ->limit(1)
        ->value('date');
    }

    public function time_difference() {
        $now = now();
        $createdAt = $this->create_date();
        return $now->diffForHumans($createdAt, true);
    }

    public function last_modification() {
        $now = now();
        $modifiedAt = $this->last_date();
        return $now->diffForHumans($modifiedAt, true);
    }
}
