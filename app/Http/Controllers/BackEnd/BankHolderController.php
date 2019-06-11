<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\BankHolderRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\BankHolder;
use App\Models\BackEnd\Banks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BankHolderController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $bankaccount = BankHolder::getAllRecord(0);
            $datatables = Datatables::of($bankaccount)->addColumn('action', function ($bankaccount) {
                $id = $bankaccount->id;
                $entity = 'bankaccounts';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/bankaccounts') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small>Phone: {{$phone}}</small>')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'number', 'name' => 'number', 'title' => 'Bank Account Number'],
            ['data' => 'balance', 'name' => 'balance', 'title' => 'Balance'],
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
        return view('backend.bankholder.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank = Banks::where('status', 1)->pluck('name','id')->all();
        return view('backend.bankholder.create')->with('bank', $bank);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankHolderRequest $request)
    {
        $bankacc =new BankHolder;
        $bankacc->name = $request->input('name');
        $bankacc->bank_id = $request->input('bank_id');
        $bankacc->number = $request->input('number');
        $bankacc->phone =$request->input('phone');
        $bankacc->balance = $request->input('balance');
        $bankacc->address = $request->input('address');
        $bankacc->type = $request->input('type');
        $bankacc->status = ($request->has('status') == true) ? 1 : 0;
        $bankacc->save();
        \Alert::success(trans('menu.$bankacc') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccounts');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccounts' . $bankacc->id . '/edit');
        }
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
        $record = BankHolder::find($id);
        $bank = Banks::where('status', 1)->pluck('name','id')->all();
        return view('backend.bankholder.edit')->with('record',$record)->with('bank',$bank);
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
        $bankacc = BankHolder::findOrfail($id);
        $bankacc->name = $request->input('name');
        $bankacc->bank_id = $request->input('bank_id');
        $bankacc->number = $request->input('number');
        $bankacc->phone =$request->input('phone');
        $bankacc->balance = $request->input('balance');
        $bankacc->address = $request->input('address');
        $bankacc->type = $request->input('type');
        $bankacc->status = ($request->has('status') == true) ? 1 : 0;
        $bankacc->save();
        \Alert::success(trans('menu.$bankacc') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccounts');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccounts' . $bankacc->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                BankHolder::whereIn('id', $id)->delete();
                $message = trans('menu.bankholder') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                BankHolder::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.bankholder') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            BankHolder::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bankholder') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }
    public function checkStatus(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status == 1){
            $status = 0;
        }elseif ($status == 0){
            $status = 1;
        }
        $upstatus = BankHolder::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.bankholder') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }
    public function checkMultiple(Request $request){
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        BankHolder::whereIn('id', $id)->update(['status'=>$status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bankholder') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bankholder') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
