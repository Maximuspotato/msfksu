<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\UserSection;
use \Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        $userSect = UserSection::where('email', $user->email)->first();
        if ($userSect->oc == 'INTERNATIONAL') {
            $request->session()->put('position', 'international');
        }else{
            if ($userSect->level == 'hq') {
                $request->session()->put('position', 'hq');
                $request->session()->put('oc', $userSect->oc);
            }else{
                $request->session()->put('position', 'field');
                $request->session()->put('oc', $userSect->oc);
                $request->session()->put('country_code', $userSect->country);
            }
        }
        return redirect('/');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function username(){
    //     return 'name';
    // }

    public function showLoginForm()
    {
        //$clients = User::orderBy('name', 'asc')->get();
        return view('auth.login')->with(['active' => '']);
    }
}
