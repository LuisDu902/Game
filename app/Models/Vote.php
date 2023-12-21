<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Vote extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'vote';

    protected $fillable = [
        'user_id',
        'question_id',
        'answer_id',
    ];

    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answer() {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function question() {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
