<?php

namespace App\Http\Controllers\BackEnd;

use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\GameMarket;
use App\Models\BackEnd\SiteLock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SiteLockController extends Controller
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
            $sitelock = SiteLock::getAllRecord(0);
            $datatables = Datatables::of($sitelock)->addColumn('action', function ($sitelock) {
                $id = $sitelock->id;
                $entity = 'sitelocks';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('description','{!! $description !!}')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['description','action', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'lock_from', 'name' => 'lock_from', 'title' => 'From'],
            ['data' => 'lock_to', 'name' => 'lock_to', 'title' => 'To'],
            ['data' => 'market', 'name' => 'market', 'title' => 'Market'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
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
        return view('backend.systemsetting.sitelock.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $market = GameMarket::where('status', 1)->where('is_trashed', 0)->get();
        return view('backend.systemsetting.sitelock.create')->with('market', $market);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $siteLock = new SiteLock;
        $siteLock->userid = $request->userid;
        $siteLock->lock_from = $request->from;
        $siteLock->lock_to = $request->to;
        $siteLock->market = $request->market;
        $siteLock->description = $request->desc;
        $siteLock->status = ($request->has('status') == true) ? 1 : 0;
        $siteLock->date = Carbon::now();
        $siteLock->save();
        \Alert::success(trans('menu.sitelock') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/sitelocks');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/sitelocks/' . $siteLock->id . '/edit');
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
        $record = SiteLock::find($id);
        $market = GameMarket::where('status', 1)->get();
        return view('backend.systemsetting.sitelock.edit')->with('record',$record)->with('market', $market);
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
//        dd($request->all());
        $siteLock = SiteLock::find($id);
        $siteLock->userid = $request->userid;
        $siteLock->lock_from = $request->from;
        $siteLock->lock_to = $request->to;
        $siteLock->market = $request->market;
        $siteLock->description = $request->desc;
        $siteLock->status = ($request->has('status') == true) ? 1 : 0;
        $siteLock->date = Carbon::now();
        $siteLock->save();
        \Alert::success(trans('menu.sitelock') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/sitelocks');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/sitelocks/' . $siteLock->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                SiteLock::whereIn('id', $id)->delete();
                $message = trans('menu.sitelock') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                SiteLock::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.sitelock') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            SiteLock::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.sitelock') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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
        $upstatus = SiteLock::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.sitelock') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        SiteLock::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.sitelock') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.sitelock') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
