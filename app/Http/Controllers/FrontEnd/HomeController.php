<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
class HomeController extends Controller
{
   public function home(){
      return view('frontend.homepage');
   }
}
