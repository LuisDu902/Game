<?php

namespace App\Http\Controllers;

use App\Models\GameCategory;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = GameCategory::paginate(10);
        return view('pages.categories', ['categories' => $categories]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $gameCategory = GameCategory::findOrFail($id);
        return view('pages.category', ['category' => $gameCategory]);
    }

}
