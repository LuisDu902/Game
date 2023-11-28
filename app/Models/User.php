<?php

namespace App\Models;

use Auth;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'description',
        'rank',
        'badges',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'badges' => 'array',
    ];


    public function questions() : HasMany {
        return $this->hasMany(Question::class);
    }
    public function games() : HasMany {
        return $this->hasMany(Game::class);
    }

    public function answers() : HasMany {
        return $this->hasMany(Answer::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badge', 'user_id', 'badge_id');
    }

     public function hasVoted($questionId)
    {
        return DB::table('vote')
            ->where('vote_type', 'Question_vote')
            ->where('question_id', $questionId)
            ->where('user_id', $this->id)
            ->exists();   
    }

    public function voteType($questionId)
    {
        $vote = DB::table('vote')
            ->where('vote_type', 'Question_vote')
            ->where('question_id', $questionId)
            ->where('user_id', $this->id)
            ->first();
        return $vote ? $vote->reaction : null;
    }
    
}
