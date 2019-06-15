<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class GameMarketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $bankaccountfroup = BankAccountGroup::getAllRecord(0);
            $datatables = Datatables::of($bankaccountfroup)->addColumn('action', function ($bankaccountfroup) {
                $id = $bankaccountfroup->id;
                $entity = 'bankaccountgroups';
                return view('backend.shared._actions', compact("id", "entity"));
            })
                ->editColumn('deposit_min', '
                <small><b>Min:</b> {{$deposit_min}}</small><br>
                <small><b>Max:</b> {{$deposit_max}}</small>')
                ->editColumn('withdraw_min', '
                <small><b>Min:</b> {{$withdraw_min}}</small><br>
                <small><b>Max:</b> {{$withdraw_max}}</small>')
                ->editColumn('bank_id', function ($query) {
                    return $query->bank->bk_name;
                })
                ->editColumn('bank_holder_id', function ($query) {
                    return $query->bank_holder->name;
                })
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['deposit_min', 'withdraw_min', 'action', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'deposit_min', 'name' => 'deposit_min', 'title' => 'Deposit'],
            ['data' => 'withdraw_min', 'name' => 'withdraw_min', 'title' => 'Withdraw'],
            ['data' => 'bank_id', 'name' => 'bank_id', 'title' => 'Bank'],
            ['data' => 'bank_holder_id', 'name' => 'bank_holder_id', 'title' => 'Bank Holder'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '60'],
        ])->parameters([
            'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
            'pagingType' => 'full_numbers',
            'bFilter' => true,
            'bSort' => true,
            'order' => [
                3,
                'ASC'
            ],
            'rowGroup' => [
                'dataSrc' => ['parent_id'],
            ]
        ]);
        return view('backend.gamemarket.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.gamemarket.create');
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
        //
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
