<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Game;
use App\Models\BackEnd\GameMarket;
use App\Models\BackEnd\GameSetting;
use App\Models\BackEnd\RefDepBonus;
use App\Models\BackEnd\RegisterDoposit;
use Illuminate\Http\Request;

class BonusRefController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $game = Game::where('status', 1)->where('is_trashed', 0)->get();
        $market = GameMarket::where('status', 1)->where('is_trashed', 0)->get();
        $regdep = RegisterDoposit::get();
        $refdep = RefDepBonus::get();
        return view('backend.systemsetting.bonusref.create')->with('game', $game)->with('market', $market)->with('regdep', $regdep)->with('refdep', $refdep);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $this->validate($request, [
        //            'reg_bonus' => 'unique:regdep_bonus,reg_bonus',
        //        ], [
        //            'reg_bonus.unique' => 'is working']);
        if (request()->ajax()) {
            // dd($request->all());
            $game_setting_id = $request->game_setting_id;
            $regdep_id = $request->input('regdep_id');
            $refdep_id = $request->input('refdep_id');
            $regdep = RegisterDoposit::find($regdep_id);
           
            if($regdep_id){
                dd($request->all());
                $gameSetting = GameSetting::find($game_setting_id);
                $regdep->reg_bonus = $request->reg_bonus;
                $regdep->dep_bonus = $request->dep_bonus;
                $regdep->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
            }elseif ($refdep_id) {
                // dd($request->all());
                $refdep = RefDepBonus::find($refdep_id);
                $refdep->ref_dep1 = $request->ref_dep1;
                $refdep->ref_dep2 = $request->ref_dep2;
                $refdep->ref_dep3 = $request->ref_dep3;
                $refdep->ref_dep4 = $request->ref_dep4;
                $refdep->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
            }
            
            
            $gameSetting->ref_bet_1 = $request->ref_bet1;
            $gameSetting->ref_bet_2 = $request->ref_bet2;
            $gameSetting->ref_bet_3 = $request->ref_bet3;
            $gameSetting->ref_bet_4 = $request->ref_bet4;
            $gameSetting->save();
            
        }
        // $game_setting_id = $request->game_setting_id;
        // $regdep_id = $request->regdep_id;
        // $refdep_id = $request->refdep_id;
        // $regdep = RegisterDoposit::find($regdep_id);
        // $refdep = RefDepBonus::find($refdep_id);
        // $gameSetting = GameSetting::find($game_setting_id);
        // $regdep->reg_bonus = $request->reg_bonus;
        // $regdep->dep_bonus = $request->dep_bonus;
        // $regdep->save();
        // $refdep->ref_dep1 = $request->ref_dep1;
        // $refdep->ref_dep2 = $request->ref_dep2;
        // $refdep->ref_dep3 = $request->ref_dep3;
        // $refdep->ref_dep4 = $request->ref_dep4;
        // $refdep->save();
        // $gameSetting->ref_bet_1 = $request->ref_bet1;
        // $gameSetting->ref_bet_2 = $request->ref_bet2;
        // $gameSetting->ref_bet_3 = $request->ref_bet3;
        // $gameSetting->ref_bet_4 = $request->ref_bet4;
        // $gameSetting->save();

        // \Alert::success(trans('menu.bonusreferalssystem') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        // if ($request->has('btnsaveclose')) {
        //     return redirect(_ADMIN_PREFIX_URL . '/bonusrefs');
        // } else {
        //     return redirect(_ADMIN_PREFIX_URL . '/bonusrefs/');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getvalue(Request $request)
    {

        if ($request->ajax()) {
            $market = $request->input('market');
            $game = $request->input('game');
            $data = GameSetting::where('market', $market)->where('game_name', $game)->get();
            return response()->json($data);
        }
    }

//    public function getValidate(Request $request){
    //        if ($request->ajax()){
    //            $test = RegisterDoposit::all();
    //            return response()->json($test);
    //        }
    //    }
}
