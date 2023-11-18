<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public $timestamps  = false;

    protected $table = 'game';

    public function members()
    {
        return $this->hasMany(User::class);
    }

    public function answers()
    {
        return;
    }

    public function questions()
    {
        return;
    }

    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'game_category_id');
    }


}
