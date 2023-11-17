<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Card extends Model
{
    use HasFactory;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

<<<<<<< Updated upstream:app/Models/Card.php
=======
    protected $table = 'question';

    protected $fillable = [
        'user_id',
        'create_date',
        'title',
    ];


   

>>>>>>> Stashed changes:app/Models/Question.php
    /**
     * Get the user that owns the card.
     */
    public function user(): BelongsTo
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

<<<<<<< Updated upstream:app/Models/Card.php
    /**
     * Get the items for the card.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
=======
     /**
     * Get the asnwers to the question.
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


>>>>>>> Stashed changes:app/Models/Question.php
}
