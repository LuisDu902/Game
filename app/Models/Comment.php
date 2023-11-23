<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


class Comment extends Model
{
    use HasFactory;


    public $timestamps  = false;

    protected $table = 'comment';

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answer() {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    /**
     * Get the latest question content.
     */
    public function latest_content()
    {
        return DB::table('version_content')
        ->select('content')
        ->where('comment_id', $this->id)
        ->orderByDesc('date') 
        ->limit(1)
        ->value('content');
    }
    





    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public static function createCommentWithContent($content, $answerId, $userId){
        
        $comment = new static;

        $comment->user_id = $userId;
        $comment->answer_id = $answerId;
        $comment->is_public = true; 
        $comment->save();

        $commentId = $comment->id;
    


   
        DB::table('version_content')->insert([
            'date' => now(),
            'content' => $content,
            'content_type' => 'Comment_content',
            'question_id' => null,
            'answer_id' => null,
            'comment_id' => $commentId,
        ]);


        return $comment;
    }


}
