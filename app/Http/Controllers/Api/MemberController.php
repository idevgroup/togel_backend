<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Tymon\JWTAuth\JWTAuth;
use App\Models\FrontEnd\Market;
use App\Models\FrontEnd\TempTransaction;
use App\Models\FrontEnd\FrontSetting;
use App\Rules\Recaptcha;
use Carbon\Carbon;
use App\Models\FrontEnd\PlayerBank;
use App\Models\FrontEnd\PlayerTransaction;
use App\Models\FrontEnd\Member;
class MemberController extends Controller {

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function dashBoard(Request $request) {
        $memberid = $request->input('memberid');
        $getTrans = TempTransaction::getTemTransaction($memberid)->orderBy('id','DESC')->get();
        $getPlayTrans = PlayerTransaction::where('playerid', $memberid)->whereNotIn('invoiceId',['DEPOSIT','WITHDRAW'])->orderBy('id', 'DESC')->get();
        $dataJson = [];
        foreach ($getPlayTrans as $row) {
                $dataJson[] = ['id' => $row->id, 'transactionid' => $row->transid, 'transactiondate' => $row->date, 'amount' => ($row->debet > 0) ? '- ' . \CommonFunction::_CurrencyFormat($row->debet) : \CommonFunction::_CurrencyFormat($row->kredit), 'status' => 1, 'transtype' => $row->invoiceId];
           
        }
        foreach ($getTrans as $row) {
            $dataJson[] = ['id' => $row->id, 'transactionid' => $row->transactid, 'transactiondate' => $row->request_at, 'amount' =>($row->proc_type !=='WITHDRAW')?\CommonFunction::_CurrencyFormat($row->amount):'- '.\CommonFunction::_CurrencyFormat($row->amount), 'status' => $row->status, 'transtype' => $row->proc_type];
        }


        return response()->json($dataJson);
    }

    public function getMarket() {
        $market = Market::getAllRecord(0, 1)->get();
        return response($market->jsonSerialize());
    }

    public function doDeposit(Request $request) {
        $numberAmount = preg_replace('/[^0-9-.]+/', '', $request->input('amount'));
        $request->merge(array('amount' => $numberAmount, 'recaptcha' => $request->input('recaptcha'), 'memberid' => $request->input('memberid'), 'note' => $request->input('note')));
        $checkDeposit = TempTransaction::whereIn('proc_type', ['deposit', 'withdraw'])->where('status', 0)->where('player_id', $request->input('memberid'))->first();
        if (!$checkDeposit) {
            $getBankId = $request->input('debank');
            $getDepositBank = $request->input('memberbank');
            $getSettingBankLimit = FrontSetting::getSettingBankLimit($getBankId);
            $getBankPlayer = PlayerBank::where('id', $getDepositBank)->with('getBank')->first();

            $getBankName = $getBankPlayer->getBank->bk_name;
            $getBankAccount = $getBankPlayer->reg_account_name;
            $getBankAccountNumber = $getBankPlayer->reg_account_number;

            $getOperatorBank = $getSettingBankLimit->bk_name;
            $getOperatorBankAccount = $getSettingBankLimit->name;
            $getOperatorBankAccNumber = $getSettingBankLimit->account_number;
            $getOperatorBankID = $getSettingBankLimit->bank_id;

            $this->validate($request, [
                'amount' => "required|numeric|max:$getSettingBankLimit->deposit_max|min:$getSettingBankLimit->deposit_min",
                'recaptcha' => ['required', new Recaptcha],
                    ], [
                'amount.required' => 'Please input amount,the field is required',
                'amount.min' => "Deposit Amount cannot less then " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->deposit_min) . " or greater than " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->deposit_max) . "!",
                'amount.max' => "Deposit Amount cannot less then " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->deposit_min) . " or greater than " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->deposit_max) . "!",
                'amount.numeric' => 'Deposit Amount can only be numeric!'
            ]);
            $tempTransaction = new TempTransaction;
            $tempTransaction->player_id = $request->input('memberid');
            $tempTransaction->bank_name = $getBankName;
            $tempTransaction->bank_acc_name = $getBankAccount;
            $tempTransaction->bank_acc_id = $getBankAccountNumber;
            $tempTransaction->amount = $numberAmount;
            $tempTransaction->deposit_bank = $getOperatorBankID;
            $tempTransaction->deposit_ac_number = $getOperatorBankAccNumber;
            $tempTransaction->deposit_bank_name = $getOperatorBank;
            $tempTransaction->deposit_ac_name = $getOperatorBankAccount;
            $tempTransaction->proc_type = 'deposit';
            $tempTransaction->ip = $request->getClientIp();
            $tempTransaction->note = $request->input('note');
            $tempTransaction->status = 0;
            $tempTransaction->request_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $tempTransaction->transactid = 'DEP-' . (int) round(microtime(true) * 1000);
            $tempTransaction->save();
            return response()->json(['success' => true, 'alert' => ['title' => 'Deposit is successfully', 'message' => 'Please wait untill our operator processed your request first!']]);
        } else {
            return response()->json(['success' => false, 'alert' => ['title' => 'Processe is pending', 'message' => 'Please wait untill our operator processed your request first!']]);
        }
    }

    public function doWithdraw(Request $request) {
        $member = Member::findOrFail($request->input('memberid'));
        $getCurrentBalance =  $member->reg_remain_balance;
        $numberAmount = preg_replace('/[^0-9-.]+/', '', $request->input('amount'));
        $request->merge(array('amount' => $numberAmount, 'recaptcha' => $request->input('recaptcha'), 'memberid' => $request->input('memberid'),'balance' => preg_replace('/[^0-9-.]+/', '',$getCurrentBalance)));
        $checkWithdraw = TempTransaction::whereIn('proc_type', ['deposit', 'withdraw'])->where('status', 0)->where('player_id', $request->input('memberid'))->first();
        if (!$checkWithdraw) {
            $getWithdrawBank = $request->input('memberbank');
            $getSettingBankLimit = FrontSetting::getLimitWithdraw();
            $getBankPlayer = PlayerBank::where('id', $getWithdrawBank)->with('getBank')->first();
            $getBankName = $getBankPlayer->getBank->bk_name;
            $getBankAccount = $getBankPlayer->reg_account_name;
            $getBankAccountNumber = $getBankPlayer->reg_account_number;
            $this->validate($request, [
                'amount' => "required|numeric|max:$getSettingBankLimit->with_max|min:$getSettingBankLimit->with_min|lte:balance",
                'recaptcha' => ['required', new Recaptcha],
                    ], [
                'amount.required' => 'Please input amount,the field is required',
                'amount.min' => "Withdraw Amount cannot less then " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->with_min) . " or greater than " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->with_max) . "!",
                'amount.max' => "Withdraw Amount cannot less then " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->with_min) . " or greater than " . \CommonFunction::_CurrencyFormat($getSettingBankLimit->with_max) . "!",
                'amount.numeric' => 'Withdraw Amount can only be numeric!',
                'amount.lte' => 'Sorry this amount have insufficient balance, please try again !!!'        
            ]);
            $tempTransaction = new TempTransaction;
            $tempTransaction->player_id = $request->input('memberid');
            $tempTransaction->bank_name = $getBankName;
            $tempTransaction->bank_acc_name = $getBankAccount;
            $tempTransaction->bank_acc_id = $getBankAccountNumber;
            $tempTransaction->amount = $numberAmount;
            $tempTransaction->proc_type = 'WITHDRAW';
            $tempTransaction->ip = $request->getClientIp();
            $tempTransaction->note = $request->input('note');
            $tempTransaction->status = 0;
            $tempTransaction->request_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $tempTransaction->transactid = 'WD-' . (int) round(microtime(true) * 1000);
            $tempTransaction->save();
            //update balance member
            $member->reg_remain_balance = (float)$member->reg_remain_balance - (float)$request->input('amount');
            $member->save();
            
            return response()->json(['success' => true, 'alert' => ['title' => 'Withdraw is successfully', 'message' => 'Please wait untill our operator processed your request first!']]);
        } else {
            return response()->json(['success' => false, 'alert' => ['title' => 'Processe is pending', 'message' => 'Please wait untill our operator processed your request first!']]);
        }
    }

    public function getBankMember(Request $request) {
        $memberId = $request->input('memberid');
        try {
            $query = PlayerBank::where('reg_id', $memberId)->with(['getBank'])->get();
            $memberBankList = array(['id' => null, 'bank' => "Select One"]);

            foreach ($query as $row) {
                $memberBankList[] = ['id' => $row->id, 'bank' => $row->getBank->bk_name . '-' . $row->reg_account_name . '-' . $row->reg_account_number];
            }
        } catch (\Exception $e) {
            \Log::error('Deposit Form Request-Select Member Bank');
            \Log::info(\URL::current());
            \Log::error($e);
        }
        return response()->json($memberBankList);
    }

    public function getBankOperator() {
        $memberBankId = request()->get('bankmember');
        $bankOperator = array(['id' => null, 'bank' => 'Select One']);
        try {
            $getBankId = PlayerBank::where('id', $memberBankId)->first();
            $getBankOperator = FrontSetting::getBankOperator($getBankId->reg_bk_id);
            foreach ($getBankOperator as $row) {
                $bankOperator[] = ['id' => $row->id, 'bank' => $getBankId->getBank->bk_name . '-' . $row->name . '-' . _covertStringX($row->account_number)];
            }
        } catch (\Exception $e) {
            \Log::error('Deposit Form Request');
            \Log::info(\URL::current());
            \Log::error($e);
        }
        return response()->json($bankOperator);
    }

}
