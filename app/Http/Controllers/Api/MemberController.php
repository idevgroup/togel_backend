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

class MemberController extends Controller {

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function dashBoard(Request $request) {
        $memberid = $request->input('memberid');
        $getTrans = TempTransaction::getTemTransaction($memberid)->get();
        $dataJson = [];
        foreach ($getTrans as $row) {
            $dataJson[] = ['id' => $row->id, 'transactionid' => $row->transactid, 'transactiondate' => $row->request_at, 'amount' => \CommonFunction::_CurrencyFormat($row->amount), 'status' => $row->status, 'transtype' => $row->proc_type];
        }
        return response()->json($dataJson);
    }

    public function getMarket() {
        $market = Market::getAllRecord(0, 1)->get();
        return response($market->jsonSerialize());
    }

    public function doDeposit(Request $request) {

        $getBankId = $request->input('debank');
        $getDepositBank = $request->input('memberbank');
        $getSettingBankLimit = FrontSetting::getSettingBankLimit($getBankId);
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
        $tempTransaction->bank_name = $request->input('bank');
        $tempTransaction->bank_acc_name = $request->input('accountname');
        $tempTransaction->bank_acc_id = $request->input('accountid');
        $tempTransaction->amount = $request->input('amount');
        $tempTransaction->deposit_bank = $request->input('debank');
        $tempTransaction->proc_type = 'deposit';
        $tempTransaction->ip = $request->getClientIp();
        $tempTransaction->note = $request->input('note');
        $tempTransaction->status = 0;
        $tempTransaction->request_at = date('Y-m-d H:i:s', strtotime(Carbon::now()));
        $tempTransaction->transactid = 'DE-' . (int) round(microtime(true) * 1000);
        $tempTransaction->save();
        return response()->json(['success' => true, 'alert' => ['title' => 'Deposit successfully', 'message' => 'Please wait untill our operator processed your request first!']]);
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
            $getBankId = PlayerBank::where('id', $memberBankId)->with('getBank')->first();
            $getBankOperator = FrontSetting::getSettingBankLimit($getBankId->reg_bk_id);
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
