<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\BetTransaction;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\Authorizable;
use Yajra\DataTables\Html\Column;
use App\Models\BackEnd\GameResult;
use App\Models\BackEnd\GameMarket;
use App\Models\BackEnd\Game;

class BetListController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder, Request $request) {
        if (request()->ajax()) {
            $marketfilter = $request->input('filtermarket');
            $gamefilter = $request->input('filtegame');
            $betTransaction = BetTransaction::with(['gameName', 'player'])->where('isCalculated', 'N');
            if (!$request->has('filtermarket') && !$request->has('filtegame')) {
                $betTransaction =$betTransaction;
            } 
            if($marketfilter != 0){ 
                $betTransaction = $betTransaction->where('market', $marketfilter);
            }else{
                $betTransaction =$betTransaction;
            }
            if($gamefilter != 0){ 
                 $betTransaction = $betTransaction->where('gameId', $gamefilter);
            }else{
                $betTransaction =$betTransaction;
            }
            
            $datatables = Datatables::of($betTransaction->orderBy('id','DESC')->get())->addColumn('action', '<a href="javascript:void(0);" class="modal-edit" data-id="{{$id}}"><i class="la la-pencil-square-o"></i></a>')->editColumn('period', '{{Str::upper($market)}}-{{$period}}')->editColumn('buy', '{{CommonFunction::_CurrencyFormat($buy)}}')->editColumn('discount', '{{CommonFunction::_CurrencyFormat($discount)}}')->editColumn('pay', '{{CommonFunction::_CurrencyFormat($pay)}}')->editColumn('player.reg_name','<a href="javascript:void(0);" class="member-id" data-id="{{$userid}}" >{{$player["reg_name"]}}</a>' )->editColumn('guess',function($row){
               return view('backend.betlist.guess', compact('row')); 
            })->rawColumns(['action','player.reg_name']);
            return $datatables->make(true);
        }
        $marketGame = GameMarket::getAllRecord(0)->pluck('name', 'code')->prepend('Select Market', '0');
        $game = Game::pluck('name', 'id')->prepend('Select Game', '0');
        $html = $builder->columns([
                    Column::make('game_name.name')->title('Game')->width(80),
                    Column::make('player.reg_name')->title('Member'),
                    Column::make('guess')->title('Guess')->addClass('text-center'),
                    Column::make('buy')->title('Bet')->addClass('text-right text-primary'),
                    Column::make('discount')->title('Discount')->addClass('text-right text-danger'),
                    Column::make('pay')->title('Pay')->addClass('text-right text-success'),
                    Column::make('period')->title('Period')->addClass('text-center'),
                    Column::make('date')->title('Bet Date')->addClass('text-center'),
                            Column::computed('action')->title('Action')
                            ->exportable(false)
                            ->printable(false)
                            ->orderable(false)
                            ->width(60)
                            ->addClass('text-center'),
                ])->parameters([
                    'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
                    'order' => [0,'desc']
                ])->postAjax([
            'data' => "function(d){
                                  d.filtermarket = $('select[name=market]').val();
                                  d.filtegame = $('select[name=cbogame]').val();
                                  d.memberid = $('#id').data('id');
                                  
                            }"
        ]);
        return view('backend.betlist.index', compact('html', 'marketGame', 'game'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $betTransaction = BetTransaction::findOrFail($id);
        
        return response()->json(['betguess'=>$betTransaction]);
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
             $this->validate($request, [
                 'marketedit'=>'required|not_in:0',
                 'inputguess' => 'required'
             ]); 
        $getPeriod = 1;
        $getPeriod += GameResult::where('market', $request->input('marketedit'))->where('isChecked', 'Y')->max('period');
        $editbet = BetTransaction::findOrFail($id);
        $editbet->market = $request->input('marketedit');
        $editbet->guess = $request->input('inputguess');
        $editbet->period = $getPeriod;
        $editbet->save();
        return response()->json(['status' => true]);
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
