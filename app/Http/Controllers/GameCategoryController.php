<?php

namespace App\Http\Controllers;

use App\Models\GameCategory;
use App\Models\Game;
use Illuminate\Http\Request;

class GameCategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:256',
            'description' => 'required'
        ]);
        
        $gameCategory = GameCategory::create([
            'name' => $request->input('name'),
            'description' => trim($request->input('description'))
        ]);

        return redirect('/categories')->with('create', 'Category successfully created!');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$categories = GameCategory::paginate(10);
        $categories = GameCategory::all();
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

    public function create()
    {
        return view('pages.newCategory');
    }

    public function edit(Request $request, $id) {
        $category = GameCategory::findOrFail($id);
        return view('pages.editCategory', ['category'=> $category]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:256',
            'description' => 'required'
        ]);

        $category = GameCategory::findOrFail($id);

        $category->name = $request->name;
        $category->description = $request->description;
        
        $category->save();
        
        return redirect("/categories/$id")->with('update', 'Category successfully updated!');
    }


    public function delete(Request $request, $id)
    {
        $category = GameCategory::findOrFail($id);
        $category->delete();
        return redirect('/categories')->with('delete', 'Category successfully deleted!');
    }

}
