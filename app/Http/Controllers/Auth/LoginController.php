<?php

namespace App\Http\Controllers\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /*
        Change the behaviour of the original Class
        \vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php
    */
    /**
     * Validate the user.
     * @todo: enable username login
     * @return username instead of email
     */
	public function username()
	{
		return 'username';
	}


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
     /*
    protected function attemptLogin(\Illuminate\Http\Request $request)
    {
    // dd( $this->credentials($request) ); // plain text credentials
    // dd( $request->filled('remember') ); // true | false from the checkbox
    // dd( $this->guard()->attempt( $this->credentials($request), $request->filled('remember')) ); // true | false Credentials Match
    // dd($this->guard()->user());  If logged in object if not null
        
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    */

   /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        // @todo: Send message User is Inactive

        if ( ! in_array($user->status,array('P','A')) ) {
            $this->logout($request);
        }
    }

}
