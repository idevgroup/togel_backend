<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\TemTransaction;
use App\DataTables\DepositDatatable;
use App\Models\BackEnd\PlayerTransaction;
use App\Models\BackEnd\Player;
use Auth;
use App\Models\BackEnd\RegisterDoposit;
use Carbon\Carbon;

class DepositTransactionController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DepositDatatable $dataTable) {
        return $dataTable->render('backend.transaction.deposit');
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
        $getAmountDeposit = TemTransaction::where('transactid', $getTransID)->where('player_id', $getMemberID)->where('status', 0)->first();


        if ($getAmountDeposit->status != 0 || is_null($getAmountDeposit)) {
            return response()->json(['title' => trans('trans.info'), 'message' => trans('trans.checkdeposit'), 'status' => 'info']);
        } else {

            $currentDeposit = $getAmountDeposit->amount;
            $getTransID = $getAmountDeposit->transactid;
            $getMemberID = $getAmountDeposit->player_id;
            $player = Player::findOrFail($getMemberID);
            $remainBalance = $player->reg_remain_balance;
            $player->reg_remain_balance = $remainBalance + $currentDeposit;
            $player->save();
            //Save Deposit Transaction
            $addTransaction = new PlayerTransaction;
            $addTransaction->invoiceId = 'DEPOSIT';
            $addTransaction->transid = $getTransID;
            $addTransaction->playerid = $getMemberID;
            $addTransaction->date = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $addTransaction->debet = 0;
            $addTransaction->kredit = $currentDeposit;
            $addTransaction->saldo = $remainBalance + $currentDeposit;
            $addTransaction->updated_by = Auth::user()->id;
            $addTransaction->descrtion = $getAmountDeposit->note;
            $addTransaction->save();

            //Check Bonus 
            $getPercentBonus = RegisterDoposit::findOrFail(1);
            $valueBonus = (float) ($currentDeposit * $getPercentBonus->dep_bonus ) / (float) 100;

            $player = Player::findOrFail($getMemberID);
            $remainBalance = $player->reg_remain_balance;
            $player->reg_remain_balance = $remainBalance + $valueBonus;
            $player->save();

            //Save Bonus Transaction
            $addTransaction = new PlayerTransaction;
            $addTransaction->invoiceId = 'DEPOSIT BONUS '. $getPercentBonus->dep_bonus . ' %';
            $addTransaction->transid = $getTransID;
            $addTransaction->playerid = $getMemberID;
            $addTransaction->date = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $addTransaction->debet = 0;
            $addTransaction->kredit = $valueBonus;
            $addTransaction->saldo = $remainBalance + $valueBonus;
            $addTransaction->updated_by = Auth::user()->id;
            $addTransaction->descrtion = 'Promote deposit bonus = ' . $getPercentBonus->dep_bonus . ' %';
            $addTransaction->save();
            $getAmountDeposit->status = 1;
            $getAmountDeposit->proc_at = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $getAmountDeposit->proc_by = Auth::user()->id;
            $getAmountDeposit->save();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.depositmsm'), 'status' => 'success']);
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
       $getAmountDeposit = TemTransaction::where('transactid', $getTransID)->where('player_id', $getMemberID)->where('status', 0)->first();
       if (is_null($getAmountDeposit)) {
            return response()->json(['title' => trans('trans.info'), 'message' => trans('trans.checkdeposit'), 'status' => 'info']);
        } else {
            $getAmountDeposit->status = 2;
            $getAmountDeposit->proc_at = date("Y-m-d H:i:s", strtotime(Carbon::now()));
            $getAmountDeposit->proc_by = Auth::user()->id;
            $getAmountDeposit->save();
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
