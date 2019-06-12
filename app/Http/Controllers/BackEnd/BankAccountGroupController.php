<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\BankAccountGroupRequest;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $bankholder = BankHolder::getAllRecord(0);
            $datatables = Datatables::of($bankholder)->addColumn('action', function ($bankholder) {
                $id = $bankholder->id;
                $entity = 'bankholders';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/bankholders') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small><b>Email:</b> {{$email}}</small>   <small><b>Phone:</b> {{$phone}}</small><br/><small><b>Gender:</b> {{$gender}}</small>   <small><b>Date of birth:</b> {{$dob}}</small><br/><small><b>Position:</b> {{$position}}</small>')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'thumb', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'thumb', 'name' => 'thumb', 'title' => 'Banner', "orderable" => false, "searchable" => false, 'width' => '80'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
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
        return view('backend.bankaccountgroup.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank_acc_group = BankAccountGroup::where('status', 1)->get();
        $bank_id = Banks::where('status', 1)->pluck('name', 'id')->all();
//        $bank_id = Banks::where('status', 1)->get();
        $bank_holder_id = BankHolder::where('status', 1)->pluck('name', 'id')->all();
        return view('backend.bankaccountgroup.create')->with('bank_id', $bank_id)->with('bank_holder_id', $bank_holder_id)->with('bank_acc_group', $bank_acc_group);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $bank_id = $request->bank_id;
//        dd($request->bank_id);
//        $request->validate([
//            'bank_id' => 'required|unique:bank_account_group,bank_holder_id'
//        ]);
        $bank_holder_id = $request->bank_holder_id;
        $bank_id = $request->bank_id;
//        dd($bank_id);
        $bank_acc_group = BankAccountGroup::where('status', 1)->get();
//        $bank_acc_group = BankAccountGroup::where('status', 1)->pluck('bank_id')->all();
        $bank_id_test = '';
        if ($bank_acc_group->isEmpty()) {
            $bankaccgroup = new BankAccountGroup;
            $bankaccgroup->name = $request->name;
            $bankaccgroup->bank_holder_id = $request->bank_holder_id;
            $bankaccgroup->deposit_min = $request->deposit_min;
            $bankaccgroup->deposit_max = $request->deposit_max;
            $bankaccgroup->withdraw_min = $request->withdraw_min;
            $bankaccgroup->withdraw_max = $request->withdraw_max;
            $bankaccgroup->bank_id = $request->bank_id;
            $bankaccgroup->status = ($request->has('status') == true) ? 1 : 0;
////        $arrbank = '';
////        foreach ($bank_id as $bank) {
////            $arrbank .= '[' . $bank . '],';
////            $arrbank .= $bank . ',';
////        }
////        dd($arrbank);
////        $bankaccgroup->bank_id = substr($arrbank, 0, -1);
            $bankaccgroup->save();
            \Alert::success(trans('menu.bankaccountgroup') . trans('trans.messageaddsuccess'), trans('trans.success'));
            if ($request->has('btnsaveclose')) {
                return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups');
            } else {
                return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups/' . $bankaccgroup->id . '/edit');
            }
        } else {
            foreach ($bank_acc_group as $test) {
                $bank_id_test = $test;
            }
            dd($bank_id_test);
            if ($bank_id_test->bank_id == $bank_id && $bank_id_test->bank_holder_id == $bank_holder_id) {
                return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups/create');
            } else {
                $bankaccgroup = new BankAccountGroup;
                $bankaccgroup->name = $request->name;
                $bankaccgroup->bank_holder_id = $request->bank_holder_id;
                $bankaccgroup->deposit_min = $request->deposit_min;
                $bankaccgroup->deposit_max = $request->deposit_max;
                $bankaccgroup->withdraw_min = $request->withdraw_min;
                $bankaccgroup->withdraw_max = $request->withdraw_max;
                $bankaccgroup->bank_id = $request->bank_id;
                $bankaccgroup->status = ($request->has('status') == true) ? 1 : 0;
////        $arrbank = '';
////        foreach ($bank_id as $bank) {
////            $arrbank .= '[' . $bank . '],';
////            $arrbank .= $bank . ',';
////        }
////        dd($arrbank);
////        $bankaccgroup->bank_id = substr($arrbank, 0, -1);
                $bankaccgroup->save();
                \Alert::success(trans('menu.bankaccountgroup') . trans('trans.messageaddsuccess'), trans('trans.success'));
                if ($request->has('btnsaveclose')) {
                    return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups');
                } else {
                    return redirect(_ADMIN_PREFIX_URL . '/bankaccountgroups/' . $bankaccgroup->id . '/edit');
                }
            }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }
}
