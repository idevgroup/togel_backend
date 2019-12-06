<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FrontEnd\Member;
use App\Http\Requests\MemberRegisterRequest;
use Carbon\Carbon;
use App\Models\FrontEnd\PlayerBank;
use App\Models\FrontEnd\FrontSetting;
use App\Models\FrontEnd\PlayerTransaction;
use App\Models\BackEnd\Referral;
class MemberRegisterController extends Controller {

    public function register(MemberRegisterRequest $request) {
        
            $getRegisterBonus =(float)FrontSetting::getBonus()->reg_bonus;
            $referral = explode('-', $request->input('referral')) ;
            $member = new Member;
            $member->reg_name = $request->input('name');
            $member->reg_username = strtolower($request->input('username'));
            $member->reg_password = _EncryptPwd($request->input('password'));
            //$member->reg_dob = $request->input('txtdob');
            $member->reg_phone = $request->input('phone');
            $member->reg_email = $request->input('email');
            //$member->reg_address = $request->input('txtaddress');
            $member->reg_ip = $request->input('ip');
            $member->lastip = $request->input('ip');
            $member->status = 1;
            $member->reg_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $member->reg_remain_balance = $getRegisterBonus;
            $member->reg_referral = $referral[0];
            $member->save();
            
            $setReferral = new Referral;
            $setReferral->playerid = $member->id;
            $setReferral->referralby = $referral[0];
            $setReferral->level = 1;
            $setReferral->save();
            
            $playerBank = new PlayerBank;
            $playerBank->reg_id = $member->id;
            $playerBank->reg_bk_id = $request->input('bank');
            $playerBank->reg_account_name = $request->input('accountname');
            $playerBank->reg_account_number = $request->input('accountid'); 
            $playerBank->reg_bank_acc_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
          
            $playerBank->save();
            
           
            
            $addTransaction = new PlayerTransaction;
            $addTransaction->invoiceId = 'Register Bonus';
            $addTransaction->transid = 'CR-' . (int) round(microtime(true) * 1000);
            $addTransaction->playerid = $member->id;
            $addTransaction->date = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $addTransaction->debet = 0;
            $addTransaction->kredit = $getRegisterBonus;
            $addTransaction->saldo = $getRegisterBonus;
            $addTransaction->descrtion = 'Register bonus';
            $addTransaction->save();

            
            return response()->json(['success' => true],200);
    }

}
