<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use Auth;
use App\Models\BackEnd\Player;
use Illuminate\Support\Facades\DB;
use App\Models\FrontEnd\TempTransaction;

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
        $player = Player::where('status' ,1)->where('is_trashed', 0)->get();
        $tempTransactionDeposit = TempTransaction::where('proc_type', 'deposit')->where('status',0)->get();
        $tempTransactionWithdraw = TempTransaction::where('proc_type', 'WITHDRAW')->where('status',0)->get();
        // where('proc_type', 'deposit')->
        // $tempTransactionCount = $tempTransaction->count();
        // dd($tempTransactionCount);
        // withCount('reg_username')->get();
        return view('backend.dashboard.index')
        ->with('player', $player)
        ->with('tempTransactionDeposit', $tempTransactionDeposit)
        ->with('tempTransactionWithdraw',$tempTransactionWithdraw);
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
