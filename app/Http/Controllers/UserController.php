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
        $users = User::orderBy('username')->paginate(10);
        return view('pages.users', ['users' => $users]);
    }

    public function list(Request $request){
        if ($request->filter == 'rank'){
            $users = User::whereRaw("LOWER(rank::text) LIKE ?", ['%' . strtolower($request->search) . '%'])
                ->when($request->filter === 'rank', function ($query) use ($request) {
                    $query->orderBy($request->order);
                })
                ->paginate(10);
        } else if ($request->filter == 'status'){
            $users = User::whereRaw('rank', ['%' . strtolower($request->search) . '%'])
                ->orderBy($request->order)
                ->paginate(10);
        } else {
            $users = User::whereRaw('LOWER(' . $request->filter . ') LIKE ?', ['%' . strtolower($request->search) . '%'])
                ->orderBy($request->order)
                ->paginate(10);
        }
        return response()->json($users);
    }

    public function updateStatus(Request $request, $id) {
        $user = User::find($id);
        $user->is_banned = ($request->status == "banned"); 
        $user->save();
        return response()->json(['status'=> 'success']);
    }

   
}
