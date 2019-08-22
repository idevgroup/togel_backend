<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use Auth;
use App\Models\BackEnd\Player;
use Illuminate\Support\Facades\DB;
use App\Models\FrontEnd\TempTransaction;
use Carbon\Carbon;
use DateTimeZone;

class DashBoardController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $player = Player::where('status' , 1)->where('is_trashed', 0)->get();
        $playerReg = Player::whereBetween('reg_date', [Carbon::today(new DateTimeZone('Asia/Phnom_Penh')),Carbon::tomorrow(new DateTimeZone('Asia/Phnom_Penh'))])->where('status' ,1)->where('is_trashed', 0)->get();
       
        $tempTransaction = TempTransaction::where('status', 0)->get();
        // dd($tempTransaction->count());
        return view('backend.dashboard.index')
        ->with('player', $player)
        ->with('tempTransaction', $tempTransaction)
        ->with('playerReg',$playerReg)
        ;
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
}
