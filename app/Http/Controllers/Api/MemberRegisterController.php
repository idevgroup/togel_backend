<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Member;
use App\Http\Requests\MemberRegisterRequest;
use Carbon\Carbon;

class MemberRegisterController extends Controller {

    public function register(MemberRegisterRequest $request) {
            $member = new Member;
            $member->reg_name = $request->input('name');
            $member->reg_username = strtolower($request->input('username'));
            $member->reg_password = _EncryptPwd($request->input('password'));
            //$member->reg_dob = $request->input('txtdob');
            //$member->reg_phone = $request->input('txtphone');
            $member->reg_email = $request->input('email');
            //$member->reg_address = $request->input('txtaddress');
            $member->reg_ip = \Request::getClientIp();
            $member->lastip = \Request::getClientIp();
            $member->status = 1;
            $member->reg_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $member->save();
            return response()->json(['success' => true, 'data' => $member->findOrFail($member->id)],200);
    }

}
