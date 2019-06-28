<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BackEnd\BlackList;
use Carbon\Carbon;
use App\Models\BackEnd\Authorizable;

class BlackListController extends Controller
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
            $blackList = BlackList::getAllRecord(0);
            $datatables = Datatables::of($blackList)->addColumn('action', function ($blackList) {
                $id = $blackList->id;
                $entity = 'blacklists';
                return view('backend.shared._actions', compact("id", "entity"));
            })
            ->editColumn('bl_description','{!! $bl_description !!}')
            ->editColumn('bl_by',function($query){
                return $query->userId->name;
            })
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['bl_description','bl_by','action', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'bl_ip', 'name' => 'bl_ip', 'title' => 'IP Address'],
            ['data' => 'bl_description', 'name' => 'bl_description', 'title' => 'Description'],
            ['data' => 'bl_date', 'name' => 'bl_date', 'title' => 'Date'],
            ['data' => 'bl_by', 'name' => 'bl_by', 'title' => 'Added By'],
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
        return view('backend.systemsetting.blacklist.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.systemsetting.blacklist.create');
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
        // dd($request->all());
        $blackList = new BlackList;
        $blackList->bl_by = $request->userid;
        $blackList->bl_ip = $request->ip;
        $blackList->bl_description = $request->desc;
        $blackList->status = ($request->has('status') == true) ? 1 : 0;
        $blackList->bl_date = Carbon::now();
        $blackList->save();
        \Alert::success(trans('menu.ipblacklist') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/blacklists');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/blacklists/' . $blackList->id . '/edit');
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
        $record = BlackList::find($id);
        return view('backend.systemsetting.blacklist.edit')->with('record',$record);
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
        // dd($request->all());
        $request->validate([
            'ip' => 'required|ip',
        ],
        [
            'name.required' => 'Please Input Name']);
        // dd($request->all());
        $blackList = BlackList::find($id);
        $blackList->bl_by = $request->userid;
        $blackList->bl_ip = $request->ip;
        $blackList->bl_description = $request->desc;
        $blackList->status = ($request->has('status') == true) ? 1 : 0;
        $blackList->bl_date = Carbon::now();
        $blackList->save();
        \Alert::success(trans('menu.ipblacklist') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/blacklists');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/blacklists/' . $blackList->id . '/edit');
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
        // dd($request->all());
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                BlackList::whereIn('id', $id)->delete();
                $message = trans('menu.ipblacklist') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                BlackList::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.ipblacklist') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            BlackList::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.ipblacklist') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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
        $upstatus = BlackList::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.ipblacklist') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        BlackList::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.ipblacklist') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.ipblacklist') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
