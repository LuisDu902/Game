<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';
    protected $fillable = [
        'date',
        'viewed',
        'user_id',
        'notification_type',
        'question_id',
        'answer_id',
        'comment_id',
        'vote_id',
        'report_id',
        'badge_id',
        'game_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function vote()
    {
        return $this->belongsTo(Vote::class, 'vote_id');
    }

    public function game()
    {
        return $this->belongsTo(Question::class, 'game_id');
    }
}
