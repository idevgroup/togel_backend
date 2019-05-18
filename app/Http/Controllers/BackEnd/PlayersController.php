<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BackEnd\PlayersController;
use App\Models\BackEnd\Authorizable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\Player;

class PlayersController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder) {
        //dd($player = Player::getRecord()->get());
        if (request()->ajax()) {
            $player = Player::getRecord();
            $datatables = Datatables::of($player)->addColumn('action', function ($player) {
                        $id = $player->id;
                        $entity = 'players';
                        return view('backend.members.player.inc.actionbtn', compact("id", "entity"));
                    })->addColumn('bank', 'null')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="chkplayer" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->editColumn('reg_name',function($query){
                            $getReferral = $query->with(['getReferral']);
                            return '<span class="p-name">'.$query->reg_name.'</span> <small>Referral:<i></i></small> ';
                    })->rawColumns(['action', 'check','reg_name']);
            return $datatables->make(true);
        }

        $html = $builder->columns([
                    ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
                    ['data' => 'reg_name', 'name' => 'reg_name', 'title' => 'Player Name'],
                    ['data' => 'reg_username', 'name' => 'reg_username', 'title' => 'Username'],
                    ['data' => 'reg_phone', 'name' => 'reg_phone', 'title' => 'Phone'],
                    ['data' => 'reg_email', 'name' => 'reg_email', 'title' => 'Email'],
                    ['data' => 'bank', 'name' => 'bank', 'title' => 'Bank Account'],
                    ['data' => 'reg_remain_balance', 'name' => 'reg_remain_balance', 'title' => 'Balance'],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '40']
                ])->parameters([
            'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
            'pagingType' => 'full_numbers',
            'bFilter' => true,
            'bSort' => true,
            'order' => [
                1,
                'ASC'
            ],
        ]);

        return view('backend.members.player.index', compact('html'));
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

}
