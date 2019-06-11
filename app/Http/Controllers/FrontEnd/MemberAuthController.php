<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\FrontEnd\Member;
use Auth;

class MemberAuthController extends Controller {

    use AuthenticatesUsers;

    protected $redirectTo = '/member';

    public function __construct() {

        $this->middleware('guest:member', ['except' => ['logout']]);
    }

    public function loginForm() {
        return view('frontend.auth.login');
    }

    protected function guard() {
        return Auth::guard('member');
    }

    public function login(Request $request) {

        // Validate the form data
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);
        $memberAuth = Member::where('reg_email', $request->username)->orWhere('reg_username',$request->username)->where('reg_password', _EncryptPwd($request->password))->where('status','1')->where('is_trashed','0')->first();
        if ($memberAuth) {
            Auth::guard('member')->login($memberAuth);
            return redirect()->intended(route('member.dashboard'));
        }
        return back()->withErrors(['username' => 'Username or password are wrong.']);
    }

    public function logout() {
        Auth::guard('member')->logout();
        return redirect('/');
    }

}
