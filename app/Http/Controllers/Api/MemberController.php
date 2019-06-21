<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Tymon\JWTAuth\JWTAuth;

class MemberController extends Controller {

   // public function __construct(JWTAuth $auth) {
       // $this->auth = $auth;
   // }
    public function dashBoard() {
      return response()->json(['success' => true]);
    }

}
