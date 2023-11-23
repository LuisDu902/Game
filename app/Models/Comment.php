<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comment';

    /**
     * Get the user that created the comment.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    /**
     * Get the answer that the comment belongs to.
     */
    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
