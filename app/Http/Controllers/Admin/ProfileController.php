<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index (Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.users.profile');
    }

    public function edit(Request $request)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        return view('admin.users.editProfile');
    }
    public function store(ProfileRequest $request, $id)
    {
        $request->user()->authorizeRoles(['employee', 'admin']);
        $user = User::find($id);
        if($user)
        {
            $path = $this->_upload($request);
            if ($path)
            {
                $user->photo = $path;
            }
            $user->update([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'email'=> $request->get('email'),
                'phone' => $request->get('phone'),
                'birthday' => Carbon::parse($request->get('birthday'))
            ]);
        }

        return redirect(route('admin.users.profile'))->with('success', __('account updated'));
        
    }
    
    private function _upload($request)
    {
        if ($request->hasFile('photo'))
        {
            $photo = $request->file('photo');
            $path = $photo->storeAs(
                'uploads', $photo->getClientOriginalName()
                );
            return $path;
        }
        return false;
    }

}
