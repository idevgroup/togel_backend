<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\GameResult;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\GameMarket;
use App\Http\Requests\SetGameResultRequest;
class SetResultController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request) {
        $marketGame = GameMarket::getAllRecord(0)->pluck('name', 'code')->prepend('Select Market', '0');
        if (request()->ajax()) {
            $filter = $request->input('filter');
            if ($filter == '0' || !$request->has('filter') || $filter == null) {
                $gameResult = GameResult::with('marketName')->orderBy('date', 'DESC');
            } else {
                $gameResult = GameResult::with('marketName')->where('market',$filter)->orderBy('date', 'DESC');
            }
            
            $datatables = Datatables::of($gameResult)->editColumn('balance', '<span @if($balance < 0 ) class="text-danger" @endif>{{CommonFunction::_CurrencyFormat($balance)}}</span>')->addColumn('action', '@if($isChecked == "N")<button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--label-warning btn-sm" data-id="{{$result_id}}" data-period="{{$market}}-{{$period}}"><i class="flaticon-edit-1"></i></button>  <button type="button" class="btn btn-secondary m-btn m-btn--custom m-btn--label-danger btn-sm" data-id="{{$result_id}}" data-period="{{$market}}-{{$period}}"><i class="flaticon-interface-5"></i></button> @endif')->editColumn('period','{{strtoupper($market)}} - {{$period}}')->rawColumns(['balance','action']);
            return $datatables->make(true);
        }
        $html = $builder->columns([
                    ['data' => 'market_name.name', 'name' => 'market_name.name', 'title' => 'Market', "orderable" => false, "searchable" => true, 'width' => '120'],
                    ['data' => 'period', 'name' => 'period', 'title' => 'Period', "orderable" => false, "searchable" => true, 'width' => '80'],
                    ['data' => 'result', 'name' => 'result', 'title' => 'Result', "orderable" => false, "searchable" => true, 'width' => '80', 'class' => 'text-center'],
                    ['data' => 'balance', 'name' => 'balance', 'title' => 'Win', "orderable" => false, "searchable" => true,  'class' => 'text-right'],
                    ['data' => 'insDate', 'name' => 'insDate', 'title' => 'Issue Date', "orderable" => false, "searchable" => true, 'width' => '180', 'class' => 'text-center'],
            ['data' => 'calDate', 'name' => 'calDate', 'title' => 'Calc-Date', "orderable" => false, "searchable" => true, 'width' => '180', 'class' => 'text-center'],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '160','class' => 'text-center']
                ])->parameters([
                    'lengthMenu' => \Config::get('sysconfig.lengthMenu')
                ])->postAjax([
            'data' => "function(d){
                                  d.filter = $('select[name=market]').val();
                            }"
        ]);
        return view('backend.game4dresult.set_result', compact('html', 'marketGame'));
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
    public function store(SetGameResultRequest $request) {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
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
     public function getPeriodMarket(Request $request) {
        $getBetMarket = $request->input('marketcode');
        
        $getPeriod = 1;
        $getPeriod += GameResult::where('market', $getBetMarket)->where('isChecked', 'Y')->max('period');
        if($getBetMarket == '0'){
            return response()->json(['period' => null]);
        }
        return response()->json(['period' => $getPeriod]);
    }
}
