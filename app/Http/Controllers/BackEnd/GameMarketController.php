<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\GameMarketRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\GameMarket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class GameMarketController extends Controller
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
            $gameMarket = GameMarket::getAllRecord(0);
            $datatables = Datatables::of($gameMarket)->addColumn('action', function ($gameMarket) {
                $id = $gameMarket->id;
                $entity = 'gamemarkets';
                return view('backend.shared._actions', compact("id", "entity"));
            })
                ->editColumn('description',
                    '{!! $description !!}')
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
            ['data' => 'name', 'name' => 'name', 'title' => trans('labels.gamemarketname')],
            ['data' => 'description', 'name' => 'description', 'title' => trans('labels.description')],
            ['data' => 'code', 'name' => 'code', 'title' => trans('labels.codename')],
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
    public function store(GameMarketRequest $request)
    {
        $gameMarket = new GameMarket;
        $gameMarket->name = $request->name;
        $gameMarket->description = $request->desc;
        $gameMarket->code = $request->code;
        $gameMarket->status = ($request->has('status') == true) ? 1 : 0;
        $gameMarket->save();
        \Alert::success(trans('menu.gamemarket') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/gamemarkets');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/gamemarkets/' . $gameMarket->id . '/edit');
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
        $record = GameMarket::findOrfail($id);
        return view('backend.gamemarket.edit')->with('record', $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(GameMarketRequest $request, $id)
    {
        $gameMarket = GameMarket::findOrfail($id);
        $gameMarket->name = $request->name;
        $gameMarket->code = $request->code;
        $gameMarket->description = $request->description;
        $gameMarket->status = ($request->has('status') == true) ? 1 : 0;
        $gameMarket->save();
        \Alert::success(trans('menu.gamemarket') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/gamemarkets');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/gamemarkets/' . $gameMarket->id . '/edit');
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
        if ($request->has('type')){
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete'){
                GameMarket::whereIn('id', $id)->delete();
                $message = trans('menu.gamemarket') . trans('trans.messagedeleted');
            }elseif ($type == 'remove'){
                GameMarket::whereIn('id', $id)->update(['is_trashed' => 1,'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.gamemarket') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        }else{
            GameMarket::findOrfail($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.gamemarket') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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
        $upstatus = GameMarket::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.gamemarket') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request){
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        GameMarket::whereIn('id', $id)->update(['status'=>$status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.gamemarket') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.gamemarket') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
