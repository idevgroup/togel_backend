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
            $bankholder= BankHolder::getAllRecord(0);
            $datatables = Datatables::of($bankholder)->addColumn('action', function ($bankholder) {
                $id = $bankholder->id;
                $entity = 'bankholders';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/bankholders') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small><b>Email:</b> {{$email}}</small>   <small><b>Phone:</b> {{$phone}}</small><br/><small><b>Gender:</b> {{$gender}}</small>   <small><b>Date of birth:</b> {{$dob}}</small><br/><small><b>Position:</b> {{$position}}</small>')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action','thumb', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'thumb', 'name' => 'thumb', 'title' => trans('labels.image'), "orderable" => false, "searchable" => false, 'width' => '80'],
            ['data' => 'name', 'name' => 'name', 'title' => trans('labels.bankholdername')],
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
        return view('backend.bankholder.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bankholder.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankHolderRequest $request)
    {
        $bankholder =new BankHolder;
        $bankholder->name = $request->input('name');
        $bankholder->email = $request->input('email');
        $bankholder->phone =$request->input('phone');
        $bankholder->position = $request->input('position');
        $bankholder->gender = $request->input('gender');
        $bankholder->dob = $request->input('dob');
        $bankholder->status = ($request->has('status') == true) ? 1 : 0;
        $bankholder->save();
        if ($request->hasFile('photo')) {
            $bankholder->uploadImage($request->file('photo'));
        }
        \Alert::success(trans('menu.bankholder') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/bankholders');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/bankholders' . $bankholder->id . '/edit');
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
        return view('backend.bankholder.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankHolderRequest $request, $id)
    {
        $bankholder = BankHolder::findOrfail($id);
        $bankholder->name = $request->input('name');
        $bankholder->email = $request->input('email');
        $bankholder->phone =$request->input('phone');
        $bankholder->position = $request->input('position');
        $bankholder->gender = $request->input('gender');
        $bankholder->dob = $request->input('dob');
        $bankholder->status = ($request->has('status') == true) ? 1 : 0;
        $bankholder->save();
        if ($request->hasFile('photo')) {
            $bankholder->uploadImage($request->file('photo'));
        }
        \Alert::success(trans('menu.bankholder') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/bankholders');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/bankholders' . $bankholder->id . '/edit');
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
