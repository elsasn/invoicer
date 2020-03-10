<?php namespace App\Http\Controllers\ClientArea\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class AuthController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/
    use AuthenticatesUsers;

	protected $loginPath = '/clientarea/login';
	//protected $username = 'username';

	public function __construct(){
		$this->middleware('guest', ['except' => 'getLogout']);
	}
    public function getLogin(){
        return view('clientarea.auth.login');
    }
    public function postLogin(Request $request){
		// get our login input
		$login = $request->input('login');
		// check login field
		$login_type = filter_var($login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
		// merge our login field into the request with either email or username as key
		$request->merge([ $login_type => $login ]);
		// let's validate and set our credentials
        $this->validate($request, [
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only( 'email', 'password' );
		if (auth()->guard('user')->attempt($credentials, $request->has('remember'))){
			return redirect()->route('client_dashboard');
		}
		return redirect()->back()->withInput($request->only('login', 'remember'))->withErrors(['login' => 'Invalid Login Credentials !']);
	}
    public function getLogout(){
        auth()->guard('user')->logout();
        return redirect()->route('client_login');
    }
}
