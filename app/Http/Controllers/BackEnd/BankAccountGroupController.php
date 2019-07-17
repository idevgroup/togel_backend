<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\BankAccountGroup;
use App\Models\BackEnd\BankHolder;
use App\Models\BackEnd\Banks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Validation\Rule;

class BankAccountGroupController extends Controller
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
            $bankaccountgroup = BankAccountGroup::getAllRecord(0);
            $datatables = Datatables::of($bankaccountgroup)->addColumn('action', function ($bankaccountgroup) {
                $id = $bankaccountgroup->id;
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
            ['data' => 'name', 'name' => 'name', 'title' => trans('labels.bankaccountgroupname')],
            ['data' => 'deposit_min', 'name' => 'deposit_min', 'title' => trans('labels.deposit')],
            ['data' => 'withdraw_min', 'name' => 'withdraw_min', 'title' => trans('labels.withdraw')],
            ['data' => 'bank_id', 'name' => 'bank_id', 'title' => trans('labels.bankname')],
            ['data' => 'bank_holder_id', 'name' => 'bank_holder_id', 'title' => trans('labels.bankholdername')],
            ['data' => 'status', 'name' => 'status', 'title' => trans('labels.status'), "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'action', 'name' => 'action', 'title' => trans('labels.action'), "orderable" => false, "searchable" => false, 'width' => '60'],
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
        return view('backend.bankaccountgroup.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $bank_acc_group = BankAccountGroup::where('status', 1)->get();
        $bank_id = Banks::where('status', 1)->pluck('bk_name', 'id')->prepend('Select One', '')->all();
//        $bank_id = Banks::where('status', 1)->get();
        $bank_holder_id = BankHolder::where('status', 1)->pluck('name', 'id')->prepend('Select One', '')->all();
        return view('backend.bankaccountgroup.create')->with('bank_id', $bank_id)->with('bank_holder_id', $bank_holder_id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request, [
            'name' => 'required|min:2',
            'bank_id' => 'required|unique:bank_account_group,bank_id,NULL,NULL,bank_holder_id,' . $request->input('bank_holder_id'),
            'bank_holder_id' => 'required'
        ], [
            'name.required' => 'Please Input Name Account Group',
            'name.min' => 'Name is Minimum 2 character',
            'bank_id.unique' => 'This Bank has already with this Bank holder']);


        $bank_holder_id = $request->bank_holder_id;
        $bank_id = $request->bank_id;
        $bankaccgroup = new BankAccountGroup;
        $bankaccgroup->name = $request->name;
        $bankaccgroup->bank_holder_id = $bank_holder_id;
        $bankaccgroup->deposit_min = $request->deposit_min;
        $bankaccgroup->deposit_max = $request->deposit_max;
        $bankaccgroup->withdraw_min = $request->withdraw_min;
        $bankaccgroup->withdraw_max = $request->withdraw_max;
        $bankaccgroup->bank_id = $bank_id;
        $bankaccgroup->status = ($request->has('status') == true) ? 1 : 0;

        $bankaccgroup->save();
        \Alert::success(trans('menu.bankaccountgroup') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups/' . $bankaccgroup->id . '/edit');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        $record = BankAccountGroup::find($id);
        $bank_holder_id = BankHolder::where('status', 1)->pluck('name', 'id')->prepend('Select One', '')->all();
        $bank_id = Banks::where('status', 1)->pluck('bk_name', 'id')->prepend('Select One', '')->all();
        return view('backend.bankaccountgroup.edit')
            ->with('record', $record)
            ->with('bank_holder_id', $bank_holder_id)
            ->with('bank_id', $bank_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|min:2',
            'bank_id' => 'required|unique:bank_account_group,bank_id,' . $id . ',id,bank_holder_id,' . $request->input('bank_holder_id'),
            'bank_holder_id' => 'required'
        ], [
            'name.required' => 'Please Input Name Account Group',
            'name.min' => 'Name is Minimum 2 character',
            'bank_id.unique' => 'This Bank has already with this Bank holder']);

        $bank_holder_id = $request->bank_holder_id;
        $bank_id = $request->bank_id;
        $bankaccgroup = BankAccountGroup::find($id);
        $bankaccgroup->name = $request->name;
        $bankaccgroup->bank_holder_id = $bank_holder_id;
        $bankaccgroup->deposit_min = $request->deposit_min;
        $bankaccgroup->deposit_max = $request->deposit_max;
        $bankaccgroup->withdraw_min = $request->withdraw_min;
        $bankaccgroup->withdraw_max = $request->withdraw_max;
        $bankaccgroup->bank_id = $bank_id;
        $bankaccgroup->status = ($request->has('status') == true) ? 1 : 0;

        $bankaccgroup->save();
        \Alert::success(trans('menu.bankaccountgroup') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups/' . $bankaccgroup->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Request $request, $id)
    {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                BankAccountGroup::whereIn('id', $id)->delete();
                $message = trans('menu.bankaccountgroup') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                BankAccountGroup::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.bankaccountgroup') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            BankAccountGroup::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bankaccountgroup') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status == 1) {
            $status = 0;
        } elseif ($status == 0) {
            $status = 1;
        }
        $upstatus = BankAccountGroup::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.bankaccountgroup') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        BankAccountGroup::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bankaccountgroup') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bankaccountgroup') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
