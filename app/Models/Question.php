<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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

}
