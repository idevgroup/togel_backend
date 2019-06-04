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
use Carbon;

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
        $player->reg_date = \Carbon\Carbon::now();
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
        return Datatables::of(PlayerTransaction::where('playerid', $id)->whereBetween('date', [$start, $end]))->make(true);
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
        $player->reg_date = \Carbon\Carbon::now();
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
    public function destroy(Request $request,$id) {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                Player::whereIn('id', $id)->delete();
                $message = trans('trans.player') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                Player::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
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
    
    public function playerBank(Request $request){
        $pId = $request->input('pId');
        $playerBalance = Player::findOrFail($pId)->reg_remain_balance;
        $playerBank = PlayerBanks::where('reg_id',$pId)->with('getBank')->get();
        return response()->json(['record' => $playerBank,'balance' =>$playerBalance ]);
    }
    public function updateBalance(Request $request){
    
    }

}
