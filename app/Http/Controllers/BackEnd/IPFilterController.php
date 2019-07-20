<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\IPFilter;

class IPFilterController extends Controller
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
            $ip = IPFilter::getAllRecord(0);
            $datatables = Datatables::of($ip)->addColumn('action', function ($ip) {
                $id = $ip->id;
                $entity = 'ipfilters';
                return view('backend.shared._actions', compact("id", "entity"));
            })
                ->editColumn('description', '{!! $description !!}')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                'data-id' => '{{$id}}',
            ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['description', 'action', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'ip', 'name' => 'ip', 'title' => trans('labels.ip_address')],
            ['data' => 'description', 'name' => 'description', 'title' => trans('labels.description')],
            ['data' => 'status', 'name' => 'status', 'title' => trans('labels.status'), "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'action', 'name' => 'action', 'title' => trans('labels.action'), "orderable" => false, "searchable" => false, 'width' => '60'],
        ])->parameters([
            'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
            'pagingType' => 'full_numbers',
            'bFilter' => true,
            'bSort' => true,
            'order' => [
                3,
                'ASC',
            ],
            'rowGroup' => [
                'dataSrc' => ['parent_id'],
            ],
        ]);
        return view('backend.systemsetting.ip.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.systemsetting.ip.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ip' => 'required|ip',
        ],
        [
            'name.required' => 'Please Input Name']);
        $ip = new IPFilter;
        $ip->ip = $request->ip;
        $ip->description = $request->desc;
        $ip->status = ($request->has('status') == true) ? 1 : 0;
        $ip->save();
        \Alert::success(trans('menu.ipfiter') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/ipfilters');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/ipfilters/' . $ip->id . '/edit');
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
        $record = IPFilter::find($id);
        return view('backend.systemsetting.ip.edit')->with('record', $record);
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
        $request->validate([
            'ip' => 'required|ip',
        ],
        [
            'name.required' => 'Please Input Name']);
        $ip = IPFilter::find($id);
        $ip->ip = $request->ip;
        $ip->description = $request->desc;
        $ip->status = ($request->has('status') == true) ? 1 : 0;
        $ip->save();
        \Alert::success(trans('menu.ipfiter') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/ipfilters');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/ipfilters/' . $ip->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                IPFilter::whereIn('id', $id)->delete();
                $message = trans('menu.ipfiter') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                IPFilter::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.ipfiter') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            IPFilter::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.ipfiter') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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
        $upstatus = IPFilter::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.ipfiter') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        IPFilter::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.ipfiter') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.ipfiter') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
