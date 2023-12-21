<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function home(){
        $games = Game::inRandomOrder()->limit(5)->get();
        return view('pages.home', ['games' => $games]);
    }
    
    public function faq(){
        return view('pages.faq');
    }

    public function about(){
        return view('pages.about');
    }

    public function contact(){
        return view('pages.contact');
    }
}
