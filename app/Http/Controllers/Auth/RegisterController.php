<?php

namespace App\Http\Controllers\Auth;

use App\Classes\ActivationService;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    protected $activationService;

    public function show()
    {
        return view('auth.register');
    }
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware('guest');
        $this->activationService = $activationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'                 => 'required|max:255',
            'username'             => 'required|unique:users|max:255',
            'email'                => 'required|max:255|unique:users',
            'password'             => 'required|min:6|confirmed',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function store()
    {
        $user = User::create(request(['name', 'username', 'email', 'password']));
        $user
            ->roles()
            ->attach(Role::where('name', 'employee')->first());
        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->store($request->all());
        event(new Registered($user));

        $this->activationService->sendActivationMail($user);

        return redirect('/login')->with('status', 'Bạn hãy kiểm tra email và thực hiện xác thực theo hướng dẫn.');
    }

    public function activateUser($token)
    {
        if ($user = $this->activationService->activateUser($token)) {
            Auth::login($user);
            return redirect('/login');
        }
        abort(404);
    }

}
