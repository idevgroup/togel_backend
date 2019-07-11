<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\TemTransaction;
use App\DataTables\WithdrawDatatable;
use App\Models\BackEnd\PlayerTransaction;
use App\Models\BackEnd\Player;
use Auth;
use App\Models\BackEnd\RegisterDoposit;
use Carbon\Carbon;

class WithdrawTransactionController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(WithdrawDatatable $dataTable) {
        return $dataTable->render('backend.transaction.withdraw');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $getTransID = $request->input('transID');
        $getMemberID = $request->input('memberId');
        $getAmountWithdraw = TemTransaction::where('transactid', $getTransID)->where('player_id', $getMemberID)->where('status', 0)->first();


        if ($getAmountWithdraw->status != 0 || is_null($getAmountWithdraw)) {
            return response()->json(['title' => trans('trans.info'), 'message' => trans('trans.checkdeposit'), 'status' => 'info']);
        } else {

            $currentWithdraw = $getAmountWithdraw->amount;
            $getTransID = $getAmountWithdraw->transactid;
            $getMemberID = $getAmountWithdraw->player_id;
            $player = Player::findOrFail($getMemberID);
            $remainBalance = $player->reg_remain_balance;
            
            //Save Deposit Transaction
            $addTransaction = new PlayerTransaction;
            $addTransaction->invoiceId = 'WITHDRAW';
            $addTransaction->transid = $getTransID;
            $addTransaction->playerid = $getMemberID;
            $addTransaction->date = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $addTransaction->debet = $currentWithdraw;
            $addTransaction->kredit = 0;
            $addTransaction->saldo = $remainBalance ;
            $addTransaction->updated_by = Auth::user()->id;
            $addTransaction->descrtion = $getAmountWithdraw->note;
            $addTransaction->save();

            $getAmountWithdraw->status = 1;
            $getAmountWithdraw->proc_at = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $getAmountWithdraw->proc_by = Auth::user()->id;
            $getAmountWithdraw->save();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.withdrawmsm'), 'status' => 'success']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $temTransaction = TemTransaction::where('transactid', $id)->with(['players'])->first();
        $viewTranscation = view('backend.transaction.inc._viewtransaction')->with('temTransaction', $temTransaction)->render();
        \Log::info($temTransaction);
        return response()->json(['html' => $viewTranscation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $getTransID = $request->input('transID');
        $getMemberID = $request->input('memberId');
        $getAmountWithdraw = TemTransaction::where('transactid', $getTransID)->where('player_id', $getMemberID)->where('status', 0)->first();
        if (is_null($getAmountWithdraw)) {
            return response()->json(['title' => trans('trans.info'), 'message' => trans('trans.checkdeposit'), 'status' => 'info']);
        } else {
            $getAmountWithdraw->status = 2;
            $getAmountWithdraw->proc_at = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $getAmountWithdraw->proc_by = Auth::user()->id;
            $getAmountWithdraw->save();
            
            $player = Player::findOrFail($getMemberID);
            $remainBalance = $player->reg_remain_balance;
            $player->reg_remain_balance = (float)$remainBalance + (float)$getAmountWithdraw->amount;
            $player->save();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.depositreject'), 'status' => 'success']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
