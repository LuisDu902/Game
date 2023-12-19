<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'report';

    protected $fillable = [
        'date', 'reason', 'explanation', 'is_solved', 'reporter_id', 'reported_id', 'report_type', 'question_id', 'answer_id', 'comment_id'
    ];

    
}


