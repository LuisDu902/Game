<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;

use App\Models\User;

use App\Policies\UserPolicy;

class UserController extends Controller
{

    /**
     * Display a login form.
     */
    public function showUserProfile()
    {
        return view('pages.profile');
    }

    public function edit(Request $request)
    {
      $user = User::find($request->id);
      $this->authorize('edit', [$user, Auth::user()]);
      $user->name = $request->input('name');
      $user->username = $request->input('username');


      if($request->input('email') != ""){
        $user->email = $request->input('email');
      }

      $user->description = $request->input('description');


      $user->save();
      return redirect()->route('profile');
    }

    
   
}
