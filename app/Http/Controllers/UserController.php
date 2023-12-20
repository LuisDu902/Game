<?php
 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Illuminate\View\View;
use App\Models\User;

use App\Policies\UserPolicy;

use HasFactory, Notifiable;

class UserController extends Controller
{ 
    public function showUserProfile($id) {

        $user = User::find($id);

        if (!$user) {
          abort(404, 'User not found');
        }

        return view('pages.profile', ['user' => $user]);
    }

    public function search(Request $request){
        $order = $request->input('order', 'username');
        $filter = $request->input('filter', '');
        $search = $request->input('search', '');

        $query = User::where(function ($query) use ($search) {
            $query->where('username', 'ilike', "%$search%")
                  ->orWhere('name', 'ilike', "%$search%");
        });


        if (in_array($filter, ['Bronze', 'Gold', 'Master']))  $query->where('rank', $filter);
        elseif ($filter === 'Active') $query->where('is_banned', false);
        elseif ($filter === 'Banned') $query->where('is_banned', true);

        
        $users = $query->where('id', '!=', 1)->orderBy($order)->paginate(10);

        return view('partials._usersTable', compact('users'))->render();
    }

    public function updateStatus(Request $request, $id) {
        $this->authorize('updateStatus', [Auth::user()]);
        $user = User::find($id);
        $user->is_banned = ($request->status == "banned"); 
        $user->save();
        return response()->json(['status'=> 'success']);
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
      return response()->json(['profile update'=> 'success']);
    }
   


    public function showUserQuestions($id) {

        $user = User::find($id);
        
        if (!$user) {
            abort(404);
        }

        $questions = $user->questions()->paginate(10);

        return view('pages.userQuestions', ['user' => $user, 'questions' => $questions]);
    }

    public function showUserAnswers($id) {

        $user = User::find($id);
        
        if (!$user) {
            abort(404);
        }

        $answers = $user->answers; 
        return view('pages.userAnswers', ['user' => $user, 'answers' => $answers]);
    }

    public function delete(Request $request, $id) {

        $user = User::find($id);
        
        if (!$user) {
            abort(404);
        }

        $this->authorize('delete', [auth()->user(), $user]);

        $user->delete();

        return response()->json(['id' => $user->id ]); 
    }

}
