<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
		protected $loginPath = '/login';
	    use AuthenticatesUsers;

		public function __construct(){
			$this->middleware('guest', ['except' => 'getLogout']);
		}
    public function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function create(array $data){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
	public function postLogin(Request $request){
		// get our login input
		$login = $request->input('login');
		// check login field
		$login_type = filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'username';
		// merge our login field into the request with either email or username as key
		$request->merge([ $login_type => $login ]);
		// let's validate and set our credentials
		if ($login_type == 'email'){
			$this->validate($request, [
				'email'    => 'required|email',
				'password' => 'required',
			]);
			$credentials = $request->only( 'email', 'password' );
		} else {
			$this->validate($request, [
				'username' => 'required',
				'password' => 'required',
			]);
			$credentials = $request->only( 'username', 'password' );
		}
		if (auth()->guard('admin')->attempt($credentials)){
			return redirect()->route('home');
		}
        return redirect()->back()->withInput($request->only('login', 'remember'))->withErrors(['login' => 'Invalid Login Credentials !']);
	}
    public function getLogout(){
        auth()->guard('admin')->logout();
        return redirect()->route('admin_login');
    }
}
