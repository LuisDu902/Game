<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function statistics() {
        $users = User::where('id', '!=', 1)->orderBy('username')->paginate(10);
        return view('pages.admin', ['users' => $users]);
    }

    public function users() {
        $users = User::where('id', '!=', 1)->orderBy('username')->paginate(10);
        return view('partials._users', compact('users'))->render();
    }

    public function stats() {

    }
}
