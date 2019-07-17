<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\GameRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class GamesController extends Controller
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
            $game = Game::getAllRecord(0);
            $datatables = Datatables::of($game)->addColumn('action', function ($game) {
                $id = $game->id;
                $entity = 'games';
                return view('backend.shared._actions', compact("id", "entity"));
            })
                ->editColumn('description',
                    '{!! $description !!}')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['description', 'action', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'name', 'name' => 'name', 'title' => trans('labels.gamename')],
            ['data' => 'description', 'name' => 'description', 'title' => trans('labels.description')],
            ['data' => 'code', 'name' => 'code', 'title' => trans('codename')],
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
        return view('backend.game.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.game.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request)
    {
//        dd($request->all());
        $game = new Game;
        $game->name = $request->name;
        $game->code = $request->code;
        $game->description = $request->description;
        $game->status = ($request->has('status') == true) ? 1 : 0;
        $game->save();
        \Alert::success(trans('menu.game') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/games');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/games/' . $game->id . '/edit');
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
        $record = Game::findOrfail($id);
        return view('backend.game.edit')->with('record', $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(GameRequest $request, $id)
    {
        $game = Game::findOrfail($id);
        $game->name = $request->name;
        $game->code = $request->code;
        $game->description = $request->description;
        $game->status = ($request->has('status') == true) ? 1 : 0;
        $game->save();
        \Alert::success(trans('menu.game') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/games');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/games/' . $game->id . '/edit');
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
            $id = explode(',', $request->input('checkedid'));
            $type = $request->input('type');
            if ($type == 'delete'){
                $game = Game::whereIn('id', $id)->delete();
                $message = trans('menu.game') . trans('trans.messagedeleted');
            }elseif ($type == 'remove'){
                $game = Game::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.game') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        }else{
            Game::findOrfail($id)->delete();
            $message = trans('menu.game') . trans('trans.messagedeleted');
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.game') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request){
        $status = $request->status;
        $id = $request->id;
        if($status == 1){
            $status =0;
        }elseif ($status ==0){
            $status=1;
        }
        $upstatus = Game::find($id);
        $upstatus->status = $status;
        $upstatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.game') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }
    public function checkMultiple(Request $request){
        $status = $request->input('status');
        $id = explode(',', $request->input('checkedid'));
        $game = Game::whereIn('id', $id)->update(['status'=>$status]);
         if ($status == 1) {
             return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.game') . trans('trans.messageactive'), 'status' => 'success']);
         } else {
             return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.game') . trans('trans.messageunactive'), 'status' => 'warning']);
         }
    }
}
