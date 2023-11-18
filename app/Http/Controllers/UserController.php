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
        $order = $request->order;
        $filter = $request->filter;
        $search = $request->search;

        $query = User::where(function ($query) use ($search) {
            $query->where('username', 'ilike', "%$search%")
                  ->orWhere('name', 'ilike', "%$search%");
        });


        if (in_array($filter, ['Bronze', 'Gold', 'Master']))  $query->where('rank', $filter);
        elseif ($filter === 'Active') $query->where('is_banned', false);
        elseif ($filter === 'Banned') $query->where('is_banned', true);

        $users = $query->orderBy($order)->paginate(10);
        return response()->json($users);
    }

    public function updateStatus(Request $request, $id) {
        $user = User::find($id);
        $user->is_banned = ($request->status == "banned"); 
        $user->save();
        return response()->json(['status'=> 'success']);
    }

   
}
