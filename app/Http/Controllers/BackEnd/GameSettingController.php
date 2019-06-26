<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Game;
use App\Models\BackEnd\GameMarket;
use App\Models\BackEnd\GameSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class GameSettingController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $market = GameMarket::where('status', 1)->where('is_trashed', 0)->first();
//        $game = Game::where('status', 1)->where('is_trashed', 0)->first();
        $market = GameMarket::where('status', 1)->where('is_trashed', 0)->get();
        $game = Game::where('status', 1)->where('is_trashed', 0)->get();

        $gameSetting = GameSetting::all();
//        dd($game, $market, $gameSetting);
//        dd();
        return view('backend.systemsetting.gamesetting.create')->with('market', $market)->with('game', $game)->with('gameSetting', $gameSetting);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $gameMarket = GameMarket::where('status', 1)->where('is_trashed', 0)->get();
//        $game = Game::where('status', 1)->where('is_trashed', 0)->pluck('name', 'id')->all();
//        return view('backend.gamesetting.create')->with('gameMarket', $gameMarket)->with('game', $game);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $game_name = $request->game;
        $market = $request->market;
        $id = $request->id;
//        dd($game_name, $market,$id);
        $gameSetting = GameSetting::find($id);
        $gameSetting->discount = $request->discount;
        $gameSetting->menang = $request->menang;
        $gameSetting->menang_dbl = $request->menang_dbl;
        $gameSetting->menang_triple = $request->menang_triple;
        $gameSetting->menang_quadruple = $request->menang_quadruple;
        $gameSetting->kei = $request->kei;
        $gameSetting->min_bet = $request->min_bet;
        $gameSetting->max_bet = $request->max_bet;
        $gameSetting->bet_mod = $request->bet_mod;
        $gameSetting->bet_times = $request->bet_times;
        $gameSetting->save();
        \Alert::success(trans('menu.gamesetting') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/gamesettings');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/gamesettings/');
        }
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
//            dd($test);
            return response()->json($data);
        }
    }
}
