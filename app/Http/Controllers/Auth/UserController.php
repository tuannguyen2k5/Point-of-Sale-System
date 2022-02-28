<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $users = User::with('roles')->get();
        $roles = Role::with('users')->get();
        $request->user()->authorizeRoles(['admin']);
        return view('admin.users.index')->with(array('users'=>$users,'roles'=>$roles));
    }

    public function show(Request $request)
    {
        $users = User::with('roles')->get();
        $roles = Role::with('users')->get();
        $request->user()->authorizeRoles(['admin']);
        return view('admin.users.edit')->with(array('users'=>$users,'roles'=>$roles));
    }

    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $role = Role::find($request->role_id);
        if($request->add)
        {
                $role->users()->sync($request->users,false);
                return redirect(route('admin.users.edit'))->with('success',  __('Add role successfully!'));
        }
        
        if ($request->remove)
        {
            $role->users()->detach($request->users);
            return redirect(route('admin.users.edit'))->with('success',  __('Remove role successfully!'));
        }
    }
    
    public function destroy(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $user = User::find($request->input('user_id'));
        if ($user) {
            $user->delete();
            return redirect(route('admin.users.index'))->with('success', __('Delete user successfully!'));
        } else {
            return redirect(route('admin.users.index'))->with('info', __('User not found!'));
        }
    }

   
}
