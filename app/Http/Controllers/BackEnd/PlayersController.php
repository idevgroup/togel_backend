<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Player;
use App\DataTables\PlayerDatatable;
use App\Models\BackEnd\PlayerTransaction;
use Datatables;
use App\Http\Requests\PlayerRequest;
use App\Models\BackEnd\PlayerBanks;
use Carbon\Carbon;
use CommonFunction;

class PlayersController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PlayerDatatable $dataTable) {
        return $dataTable->render('backend.members.player.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.members.player.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlayerRequest $request) {
        //dd($request->all());
        $player = new Player;
        $player->reg_name = $request->input('txtname');
        $player->reg_username = strtolower($request->input('txtusername'));
        $player->reg_password = _EncryptPwd($request->input('txtpassword'));
        $player->reg_dob = $request->input('txtdob');
        $player->reg_phone = $request->input('txtphone');
        $player->reg_email = $request->input('txtemail');
        $player->reg_address = $request->input('txtaddress');
        $player->reg_ip = \Request::getClientIp();
        $player->lastip = \Request::getClientIp();
        $player->status = ($request->has('status') == true) ? 1 : 0;
        $player->reg_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
        $player->save();
        \Alert::success(trans('trans.player') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/players');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/players/' . $player->id . '/edit');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $start = request()->get('searchByStart');
        $end = request()->get('searchByEnd');
        $start = $start . " 00:00:00";
        $end = $end . " 23:59:59";
        return Datatables::of(PlayerTransaction::where('playerid', $id)->whereBetween('date', [$start, $end])->orderBy('date', 'DESC')->orderBy('saldo', 'DESC'))
                        ->editColumn('debet', '<span @if($debet < 0 ) class="text-danger" @endif>{{CommonFunction::_CurrencyFormat($debet)}} </span>')
                        ->editColumn('kredit', '<span @if($kredit < 0 ) class="text-danger" @endif>{{CommonFunction::_CurrencyFormat($kredit)}}</span>')
                        ->editColumn('saldo', '<span @if($saldo < 0 ) class="text-danger" @endif>{{CommonFunction::_CurrencyFormat($saldo)}}</span>')
                        ->editColumn('transid', '{{($transid == null)?$invoiceId:$transid}}')
                        ->rawColumns(['debet', 'kredit', 'saldo'])
                        ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $record = Player::findOrFail($id);
        return view('backend.members.player.edit')->with('record', $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlayerRequest $request, $id) {
        //dd($request->all());
        $player = Player::findOrFail($id);
        $player->reg_name = $request->input('txtname');
        $player->reg_username = $request->input('txtusername');
        if ($request->input('txtpassword') != null) {
            $player->reg_password = _EncryptPwd($request->input('txtpassword'));
        }
        $player->reg_dob = $request->input('txtdob');
        $player->reg_phone = $request->input('txtphone');
        $player->reg_email = $request->input('txtemail');
        $player->reg_address = $request->input('txtaddress');
        $player->reg_ip = \Request::getClientIp();
        $player->lastip = \Request::getClientIp();
        $player->status = ($request->has('status') == true) ? 1 : 0;
        $player->reg_date = date('Y-m-d H:i:s', strtotime(Carbon::now()));
        $player->save();
        \Alert::success(trans('trans.player') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/players');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/players/' . $id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                $playerBank = Player::whereIn('id', $id)->with('getPlayerBank')->delete();
                $message = trans('trans.player') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                Player::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => date('Y-m-d H:i:s', strtotime(Carbon::now()))]);
                $message = trans('trans.player') . trans('trans.messagemovedtrashed');
            }

            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            Player::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.category') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request) {
        if (request()->ajax()) {
            $id = $request->input('pId');
            $status = $request->input('status');
            if ($status == 1) {
                $vStatus = 0;
            } else {
                $vStatus = 1;
            }
            $player = Player::findOrFail($id);
            $player->status = $vStatus;
            $player->save();
            $message = ($vStatus == 0) ? trans('trans.blockplayer') : trans('trans.unblockplayer') . trans('trans.messageupdatesuccess');
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success', 'vStatus' => $vStatus]);
        }
    }

    public function checkMultiple(Request $request) {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        $update = Player::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.player') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.player') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }

    public function playerBank(Request $request) {
        $pId = $request->input('pId');
        $playerBalance = Player::findOrFail($pId)->reg_remain_balance;
        $playerBank = PlayerBanks::where('reg_id', $pId)->with('getBank')->get();
        return response()->json(['record' => $playerBank, 'balance' => CommonFunction::_CurrencyFormat($playerBalance)]);
    }

    public function updateBalance(Request $request) {
        $amount = $request->input('amount');
        $pid = $request->input('pId');
        $operator = $request->input('operator');
        $descBalance = $request->input('descBalance');
        if ($amount > 0) {
            $player = Player::findOrFail($pid);
            $remainBalance = $player->reg_remain_balance;
            //Add
            if ($operator == 1) {
                $player->reg_remain_balance = $player->reg_remain_balance + $amount;
            } elseif ($operator == 2) {
                //Subtract 
                $player->reg_remain_balance = $player->reg_remain_balance - $amount;
            }
            $player->save();

            $playerTransaction = new PlayerTransaction;
            if ($operator == '1') {
                $playerTransaction->invoiceId = 'CREDIT';
                $transid = 'CR-' . (int) round(microtime(true) * 1000);
            } elseif ($operator == '2') {
                $playerTransaction->invoiceId = 'DEBIT';
                $transid = 'DE-' . (int) round(microtime(true) * 1000);
            }
            $playerTransaction->transid = $transid;
            $playerTransaction->playerid = $pid;
            $playerTransaction->date = date("Y-m-d H:i:s", strtotime(Carbon::now()));


            if ($operator == '1') {
                $playerTransaction->saldo = $remainBalance + $amount;
                $playerTransaction->kredit = $amount;
                $playerTransaction->debet = 0;
            } elseif ($operator == '2') {
                $playerTransaction->saldo = $remainBalance - $amount;
                $playerTransaction->kredit = 0;
                $playerTransaction->debet = $amount;
            }
            $playerTransaction->updated_by = \Auth::user()->id;
            $playerTransaction->descrtion = $descBalance;
            $playerTransaction->save();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.balanceupdate'), 'status' => 'success', 'balance' => $player->reg_remain_balance]);
        } else {
            return response()->json(['title' => trans('trans.warning'), 'message' => trans('trans.invbalance'), 'status' => 'warning']);
        }
    }

}
