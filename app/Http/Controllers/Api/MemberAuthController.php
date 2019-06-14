<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\FrontEnd\Member;
use Auth;

class MemberAuthController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = 'v1/member/dashboard';
 
    public function __construct() {
       // $this->auth=$auth;
        $this->middleware('auth:api', ['except' => ['login']]);
        // $this->middleware('guest:member', ['except' => ['logout']]);
    }

    protected function guard() {
        return Auth::guard('api');
    }

  
    protected function credentials(Request $request) {
        return $request->only($this->username(), 'reg_password');
    }

    public function login(Request $request) {
        // Validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
        $memberAuth = Member::where('reg_email', $request->username)->orWhere('reg_username', $request->username)->where('reg_password', _EncryptPwd($request->password))->where('status', '1')->where('is_trashed', '0')->first();
        if ($memberAuth) {
            if ($request->has('remember')) {
                $token_remember = true;
            } else {
                $token_remember = false;
            }
            if (!$token = $this->guard()->login($memberAuth, $token_remember)) {
                $this->incrementLoginAttempts($request);
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $this->clearLoginAttempts($request);
            $memberAuth->rollApiKey($token);
            return $this->respondWithToken($token);
        } else {
            $this->incrementLoginAttempts($request);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout() {
        $this->guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function me() {

        return $this->respondWithToken($this->guard()->user());
    }

    protected function respondWithToken($token) {
        return response()->json([
                    'access_token' => $token,
                    'token_type' => 'bearer',
                    'data' => $this->guard()->user(),
                    'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function refresh() {
        return $this->respondWithToken($this->guard()->refresh());
    }

}
