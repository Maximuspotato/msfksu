<?php

namespace App\Http\Controllers\Auth;

ini_set('max_execution_time', 180);

use App\User;
use App\UserSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'oc' => ['required', 'string', 'max:255'],
            'country' => ['string', 'max:255'],
            'level' => ['string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (!isset($data['country'])) {
            $data['country'] = null;
        }
        if (!isset($data['level'])) {
            $data['level'] = null;
        }

        UserSection::create([
            'email' => $data['email'],
            'oc' => $data['oc'],
            'country' => $data['country'],
            'level' => $data['level']
        ]);

        return $user;
    }

    public function showRegistrationForm()
    {
        return view('auth.register')->with(['active' => '']);
    }

    public function register(Request $request)
    {
        if( strpos( $request->email, 'msf' ) !== false || strpos( $request->email, 'MSF' ) !== false) {
            $this->validator($request->all())->validate();

            event(new Registered($user = $this->create($request->all())));

            // $user_section = new UserSection;
            // $user_section->email = $request->email;
            // $user_section->oc = $request->oc;
            // $user_section->country = $request->country;
            // $user_section->save();

            return redirect($this->redirectPath())->with('reg', '');
        }
        else{
            return redirect('register')->with('error', 'You are unauthorized to perform this action');
        }
    }
}
