<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {
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
    // protected $redirectTo = '/home';
    protected $redirectTo = '/' . _ADMIN_PREFIX_URL;

    /**
     * Set how many failed logins are allowed before being locked out.
     */
    public $maxAttempts = 3;

    /**
     * Set how many seconds a lockout will last.
     */
    public $decayMinutes = 10;

    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
   // protected $username;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
        //$this->username = $this->findUsername();
    }

    protected function hasTooManyLoginAttempts(Request $request) {
        return $this->limiter()->tooManyAttempts(
                        $this->throttleKey($request), 6, 30
        );
    }

    protected function credentials(Request $request) {
       // return array_merge($request->only($this->username(), 'password'), ['status' => 1]);
         $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
            'status' => 1
        ];
    }

}
