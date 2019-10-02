<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\BackEnd\GameSetting;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\BetTransaction;
use App\Models\BackEnd\Game;
class CalculateResultController extends Controller
{
   use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function doResultXD($market,$result,$date,$period){
        DB::raw('CALL calculateXD(?,?,?,?)',[$market,$result,$date,$period]);
        return response()->json(['message' => 'Calculate 2D,3D,4D,2D Depan, 2D Tengah is ready']);
    }
    public function doResultColokBebas($market,$result,$date,$period){
        $getSetting = GameSetting::where('market',$market)->where('game_name','Colok Bebas')->first();
        $getGameId = Game::where('name','Colok Bebas')->first()->id;
         $fd = (string)$result;
         try {
               DB::beginTransaction();
               $doResult = BetTransaction::where('period',$period)->where('market',$market)->where('gameId',$getGameId)
                       ->whereDate('date','<',$date)->orWhere('guess');
               DB::commit();
         } catch (Exception $ex) {
              DB::rollBack();
            \Log::error('Do Result Colok Bebas');
            \Log::info(\URL::current());
            \Log::error($ex);
         }
    }
}
