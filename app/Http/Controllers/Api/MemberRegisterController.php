<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Member;
use App\Http\Requests\MemberRegisterRequest;
use Carbon\Carbon;
use App\Models\FrontEnd\PlayerBank;
class MemberRegisterController extends Controller {

    public function register(MemberRegisterRequest $request) {
            $member = new Member;
            $member->reg_name = $request->input('name');
            $member->reg_username = strtolower($request->input('username'));
            $member->reg_password = _EncryptPwd($request->input('password'));
            //$member->reg_dob = $request->input('txtdob');
            $member->reg_phone = $request->input('phone');
            $member->reg_email = $request->input('email');
            //$member->reg_address = $request->input('txtaddress');
            $member->reg_ip = \Request::getClientIp();
            $member->lastip = \Request::getClientIp();
            $member->status = 1;
            $member->reg_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $member->save();
            $playerBank = new PlayerBank;
            $playerBank->reg_id = $member->id;
            $playerBank->reg_bk_id = $request->input('bank');
            $playerBank->reg_account_name = $request->input('accountname');
            $playerBank->reg_account_number = $request->input('accountid'); 
            $playerBank->reg_bank_acc_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $playerBank->save();
            return response()->json(['success' => true],200);
    }

}
