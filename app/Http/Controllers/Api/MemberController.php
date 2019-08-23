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
use App\Events\MemberEvent;
use App\Models\FrontEnd\BetTransaction;
use App\Models\FrontEnd\GameResult;
use App\Models\FrontEnd\Game;

class MemberController extends Controller {

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    protected function guard() {
        return Auth::guard('api');
    }

    public function dashBoard(Request $request) {
        $memberid = $request->input('memberid');
        $getTrans = TempTransaction::getTemTransaction($memberid)->orderBy('id', 'DESC')->limit(50)->get();
        $getPlayTrans = PlayerTransaction::where('playerid', $memberid)->whereNotIn('invoiceId', ['DEPOSIT', 'WITHDRAW'])->orderBy('id', 'DESC')->limit(50)->get();
        $dataJson = [];
        foreach ($getPlayTrans as $row) {
            $dataJson[] = ['id' => $row->id, 'transactionid' => $row->transid, 'transactiondate' => $row->date, 'amount' => ($row->debet > 0) ? '- ' . \CommonFunction::_CurrencyFormat($row->debet) : \CommonFunction::_CurrencyFormat($row->kredit), 'status' => '', 'transtype' => $row->invoiceId];
        }
        foreach ($getTrans as $row) {
            $dataJson[] = ['id' => $row->id, 'transactionid' => $row->transactid, 'transactiondate' => $row->request_at, 'amount' => ($row->proc_type !== 'WITHDRAW') ? \CommonFunction::_CurrencyFormat($row->amount) : '- ' . \CommonFunction::_CurrencyFormat($row->amount), 'status' => $row->status, 'transtype' => $row->proc_type];
        }


        return response()->json(['data' => $dataJson, 'total' => count($dataJson)]);
    }

    public function getMarket() {
        $market = Market::getAllRecord(0, 1)->get();
        return response($market->jsonSerialize());
    }

    public function doDeposit(Request $request) {

        $memberId = $this->guard()->user()->id;
        $numberAmount = preg_replace('/[^0-9-.]+/', '', $request->input('amount'));
        $request->merge(array('amount' => $numberAmount, 'recaptcha' => $request->input('recaptcha'), 'memberid' => $memberId, 'note' => $request->input('note'), 'memberbank' => $request->input('memberbank'), 'debank' => $request->input('debank')));
        $checkDeposit = TempTransaction::whereIn('proc_type', ['deposit', 'withdraw'])->where('status', 0)->where('player_id', $memberId)->first();
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

            //Pusher Event 
            $dataPusher = [
                'memberId' => $memberId,
                'memberName' => $this->guard()->user()->reg_name,
                'amount' => \CommonFunction::_CurrencyFormat($request->input('amount')),
                'proc_type' => 'deposit'
            ];
            event(new MemberEvent($dataPusher));

            return response()->json(['data' => ['success' => true, 'alert' => ['title' => 'Deposit is successfully', 'message' => 'Please wait untill our operator processed your request first!']]]);
        } else {
            return response()->json(['data' => ['success' => false, 'alert' => ['title' => 'Processe is pending', 'message' => 'Please wait untill our operator processed your request first!']]]);
        }
    }

    public function doWithdraw(Request $request) {
        $member = Member::findOrFail($this->guard()->user()->id);
        $getCurrentBalance = $member->reg_remain_balance;
        $numberAmount = preg_replace('/[^0-9-.]+/', '', $request->input('amount'));
        $request->merge(array('amount' => (float) $numberAmount, 'recaptcha' => $request->input('recaptcha'), 'memberid' => $this->guard()->user()->id, 'note' => $request->input('note'), 'memberbank' => $request->input('memberbank'), 'balance' => (float) $getCurrentBalance));
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
            $member->reg_remain_balance = (float) $member->reg_remain_balance - (float) $request->input('amount');
            $member->save();
            //Pusher Event 
            $dataPusher = [
                'memberId' => $this->guard()->user()->id,
                'memberName' => $this->guard()->user()->reg_name,
                'amount' => \CommonFunction::_CurrencyFormat($request->input('amount')),
                'proc_type' => 'withdraw'
            ];
            event(new MemberEvent($dataPusher));
            return response()->json(['data' => ['success' => true, 'alert' => ['title' => 'Withdraw is successfully', 'message' => 'Please wait untill our operator processed your request first!']]]);
        } else {
            return response()->json(['data' => ['success' => false, 'alert' => ['title' => 'Processe is pending', 'message' => 'Please wait untill our operator processed your request first!']]]);
        }
    }

    public function getBankMember(Request $request) {
        $memberId = $this->guard()->user()->id;
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

    public function getBankOperator(Request $request) {
        $memberBankId = $request->input('memberBankId');
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

    public function betGameAllDigit(Request $request) {
        $member = Member::findOrFail($this->guard()->user()->id);
        $getCurrentBalance = $member->reg_remain_balance;
        $getBetItem = $request->input('betitem');
        $getBetMarket = $request->input('market');
        $getBetPay = $request->input('totalpay');
        $getCodeGame = $request->input('gamecode');
        $request->merge(array(
            'memberid' => $this->guard()->user()->id,
            'totalpay' => (float) $getBetPay,
            'balance' => (float) $getCurrentBalance,
            'gamecode' => $getCodeGame,
        ));
        $this->validate($request, [
            'memberid' => 'required',
            'totalpay' => 'required|lte:balance',
            'balance' => 'required',
                ], ['totalpay.lte' => "Sorry this amount have insufficient balance, please try again !!!"]);

        //Period my market
        $getPeriod = GameResult::where('market', $getBetMarket)->max('period');

        //Save Transaction Bet
        $playerTransaction = new PlayerTransaction;
        $playerTransaction->invoiceId = 'Bet Game ' + $getCodeGame;
        $playerTransaction->transid = 'DE-' . (int) round(microtime(true) * 1000);
        $playerTransaction->playerid = $this->guard()->user()->id;
        $playerTransaction->gameName = $getCodeGame;
        $playerTransaction->market = $getBetMarket;
        $playerTransaction->date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
        $playerTransaction->period = $getPeriod + 1;
        $playerTransaction->debet = $getBetPay;
        $playerTransaction->kredit = 0;
        $playerTransaction->saldo = (float) $getCurrentBalance - (float) $getBetPay;
        $playerTransaction->save();

        //Bet Transaction
        $getGame = \App\Models\FrontEnd\Game::where('name', $getCodeGame)->first()->id;
        foreach ($getBetItem as $item) {
            $betTransaction = new BetTransaction;
            $betTransaction->gameId = $getGame;
            $betTransaction->market = $getBetMarket;
            $betTransaction->period = $getPeriod + 1;
            $betTransaction->guess = $item['betnumber'];
            $betTransaction->discount = $item['betdiscount'];
            $betTransaction->buy = $item['betprice'];
            $betTransaction->pay = $item['betpay'];
            $betTransaction->win = (float) $item['betpay'] * (-1);
            $betTransaction->invoiceId = $playerTransaction->id;
            $betTransaction->userid = $this->guard()->user()->id;
            $betTransaction->date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $betTransaction->ip = $request->getClientIp();
            $betTransaction->save();
        }

        //update balance member
        $member->reg_remain_balance = (float) $getCurrentBalance - (float) $getBetPay;
        $member->save();
        return response()->json(['success' => true, 'alert' => ['title' => 'Process is successfully', 'message' => 'Thank you !!!']]);
    }
    public function doBetGame50(Request $request){
        $member = Member::findOrFail($this->guard()->user()->id);
        $getCurrentBalance = $member->reg_remain_balance;
        
        $oddeven = $request->input('betOddEven');
        $bigsmall = $request->input('betSmallLarge');
        $getBetTotalPay = $request->input('betTotalPay');
        $getBetMarket = $request->input('market');
        $arrayMerge = array_merge($oddeven,$bigsmall);
        
        $request->merge(array(
            'memberid' => $this->guard()->user()->id,
            'totalpay' => (float) $getBetTotalPay,
            'balance' => (float) $getCurrentBalance,
            'gamecode' => '50-50',
        ));
          $this->validate($request, [
            'memberid' => 'required',
            'totalpay' => 'required|lte:balance',
            'balance' => 'required',
                ], ['totalpay.lte' => "Sorry this amount have insufficient balance, please try again !!!"]);
        
            //Period my market
        $getPeriod = GameResult::where('market', $getBetMarket)->max('period');

        //Save Transaction Bet
        $playerTransaction = new PlayerTransaction;
        $playerTransaction->invoiceId = 'Bet Game '+$request->input('gamecode');
        $playerTransaction->transid = 'DE-' . (int) round(microtime(true) * 1000);
        $playerTransaction->playerid = $this->guard()->user()->id;
        $playerTransaction->gameName = $request->input('gamecode');
        $playerTransaction->market = $getBetMarket;
        $playerTransaction->date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
        $playerTransaction->period = $getPeriod + 1;
        $playerTransaction->debet = $getBetTotalPay;
        $playerTransaction->kredit = 0;
        $playerTransaction->saldo = (float) $getCurrentBalance - (float) $getBetTotalPay;
        $playerTransaction->save();
        
        $getGame = \App\Models\FrontEnd\Game::where('name', $request->input('gamecode'))->first()->id;
        foreach($arrayMerge as $item){
            if($item['bet'] > 0){
            $betTransaction = new BetTransaction;
            $betTransaction->gameId = $getGame;
            $betTransaction->market = $getBetMarket;
            $betTransaction->period = $getPeriod + 1;
            $betTransaction->guess = $item['Selected'];
            $betTransaction->kei = $item['kei'];
            $betTransaction->param1= $item['key'];
            $betTransaction->discount = $item['discount'];
            $betTransaction->buy = $item['bet'];
            $betTransaction->pay = $item['pay'];
            $betTransaction->win = (float) $item['pay'] * (-1);
            $betTransaction->invoiceId = $playerTransaction->id;
            $betTransaction->userid = $this->guard()->user()->id;
            $betTransaction->date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
            $betTransaction->ip = $request->getClientIp();
            $betTransaction->save();
            }
        }
        
         //update balance member
        $member->reg_remain_balance = (float) $getCurrentBalance - (float) $getBetTotalPay;
        $member->save();
        return response()->json(['success' => true, 'alert' => ['title' => 'Process is successfully', 'message' => 'Thank you !!!']]);
    }
    public function transactinPeriod(Request $request) {
        $marketcode = $request->input('marketcode');
        $getPeriod = GameResult::where('market', $marketcode)->orderBy('period', 'DESC')->get();
        $period = (int) $getPeriod->max('period') + (int) 1;

        $periodListOption = [0 => ['key' => "$marketcode-$period", 'value' => strtoupper("$marketcode-$period")]];
        foreach ($getPeriod as $row) {
            $periodListOption[] = ['key' => "$marketcode-$row->period", 'value' => strtoupper("$marketcode-$row->period / $row->date")];
        }
        return response()->json($periodListOption);
    }

    public function transactionGameList(Request $request) {
        $getRequest = $request->input('period');
        $slipValue = explode('-', $getRequest);
//        $getListTransaction = BetTransaction::where('market',$slipValue[0])->where('period',$slipValue[1])->where('userid',$this->guard()->user()->id)->get();
//        
        $getListTransaction = Game::with(['listBetTransaction' => function($query) use($slipValue) {
                        return $query->where('market', $slipValue[0])->where('period', $slipValue[1])->where('userid', $this->guard()->user()->id);
                    }])->where('is_trashed',0)->get();
                    
        $listGameTransaction = [];
        foreach($getListTransaction as $item){
            $listGameTransaction[] = [
                'gameid' => $item->id,
                'gamename' => $item->name,
                'buy' => $item->listBetTransaction->sum('buy'),
                'paid' => $item->listBetTransaction->sum('pay'),
                'win' => $item->listBetTransaction->sum('win'),
                'invoicedetail' => $item->listBetTransaction
            ];
        }
        return response()->json($listGameTransaction);
    }

}
