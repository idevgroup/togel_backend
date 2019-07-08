<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\controllers\controller;
use App\Models\BackEnd\TransactionLimit;
use Illuminate\Http\Request;
use App\Models\BackEnd\Authorizable;

class TransactionLimitController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = TransactionLimit::first();
//        dd($transaction->dep_min);
        return view('backend.systemsetting.transaction.create')->with('transaction', $transaction);
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
        //
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
        $id = $request->id;
        $withMin = str_replace(',', '', $request->with_min);
        $withMax = str_replace(',', '', $request->with_max);

        // dd($request->all());
        $request->validate([
            'with_min' => 'lt:with_max'
        ],
        [
            'with_min.lt' => 'Minimum Deposit cannot be greater than Maximum Deposit!']);


        $transaction = TransactionLimit::find($id);
        // $transaction->dep_min = str_replace(',', '', $request->dep_min);
        // $transaction->dep_max = str_replace(',', '', $request->dep_max);
        $transaction->with_min = $withMin;
        $transaction->with_max = $withMax;
        $transaction->save();
        \Alert::success(trans('menu.transactionlimitation') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/transactionlimits');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/transactionlimits/');
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
}
