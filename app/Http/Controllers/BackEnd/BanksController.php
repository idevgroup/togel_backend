<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\BanksRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Banks;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class BanksController extends Controller
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
            $bank = Banks::getAllRecord(0);
            $datatables = Datatables::of($bank)->addColumn('action', function ($bank) {
                $id = $bank->id;
                $entity = 'banks';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('bk_description', '{!! $bk_description !!}')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->editColumn('bk_thumb', '{!!_CheckImage($bk_thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['action','bk_description', 'bk_thumb', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '
            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
            <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'bk_thumb', 'name' => 'bk_thumb', 'title' => 'Image', "orderable" => false, "searchable" => false, 'width' => '80'],
            ['data' => 'bk_name', 'name' => 'bk_name', 'title' => 'Name'],
            ['data' => 'bk_link', 'name' => 'bk_link', 'title' => 'Link'],
            ['data' => 'bk_description', 'name' => 'bk_description', 'title' => 'Description'],
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
        return view('backend.bank.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(BanksRequest $request)
    {
//        dd($request->all());
        $bank = new Banks;
        $bank->bk_name = $request->name;
        $bank->bk_link = $request->link;
        $bank->bk_description = $request->desc;
        $bank->status = ($request->has('status') == true) ? 1 : 0;
        if ($request->hasFile('bannerfile')) {
            $bank->uploadImage($request->file('bannerfile'));
        }
        $bank->save();
        \Alert::success(trans('menu.bank') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/banks');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/banks' . $bank->id . '/edit');
        }
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
        $record = Banks::findOrfail($id);
//        dd($record);
        return view('backend.bank.edit')->with('record', $record);
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
        $bank = Banks::findOrfail($id);
        $bank->bk_name = $request->name;
        $bank->bk_link = $request->link;
        $bank->bk_description = $request->description;
        $bank->status = ($request->has('status') == true) ? 1 : 0;
        if ($request->hasFile('bannerfile')) {
            $bank->uploadImage($request->file('bannerfile'));
        }
        $bank->save();
        \Alert::success(trans('menu.bank') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/banks');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/banks' . $dreambook->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                Banks::whereIn('id', $id)->delete();
                $message = trans('menu.bank') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                Banks::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.category') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            Banks::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bank') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');
        if ($status == '1') {
            $status = 0;
        } elseif ($status == '0') {
            $status = 1;
        }
        $upstatus = Banks::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.bank') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        Banks::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bank') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.bank') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
