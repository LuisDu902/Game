<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\View\View;
use App\Models\User;

class UserController extends Controller
{

    /**
     * Display a login form.
     */
    public function showUserProfile()
    {
        return view('pages.profile');
    }

    public function index(){
        $users = User::paginate(10);
        return view('pages.users', ['users' => $users]);
    }
   
}
