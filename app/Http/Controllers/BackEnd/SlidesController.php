<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\SlideRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Category;
use App\Models\BackEnd\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class SlidesController extends Controller
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
            $slide = Slide::getAllRecord(0);
            $datatables = Datatables::of($slide)->addColumn('action', function ($slide) {
                $id = $slide->id;
                $entity = 'slides';
                return view('backend.shared._actions', compact("id", "entity"));
            })
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'thumb', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }

        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '
            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> 
            <input type="checkbox" value="" class="m-group-checkable"> <span></span>
            </label>', 'orderable' => false, "searchable" => false, 'width' => '40'],
            ['data' => 'thumb', 'name' => 'thumb', 'title' => 'Slide Image', 'orderable' => false, 'searchable' => false, 'width' => '80'],
            ['data' => 'alt', 'name' => 'alt', 'title' => 'Alt'],
            ['data' => 'link', 'name' => 'link', 'title' => 'Link'],
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

        return view('backend.catalogs.slide.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.catalogs.slide.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlideRequest $request)
    {
            $slide = new Slide;
            $slide->created_by = $request->user_id;
            $slide->updated_by = $request->user_id;
            $slide->alt = $request->alt;
            $slide->link = $request->link;
            $slide->status = ($request->has('status') == true) ? 1 : 0;
            $slide->save();
            if ($request->hasFile('bannerfile'))
            {
                $slide->uploadImage($request->file('bannerfile'));
            }
        \Alert::success(trans('menu.slide') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/slides');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/slides' . $dreambook->id . '/edit');
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
        $slide = Slide::findOrfail($id);
        return view('backend.catalogs.slide.edit')->with('slide', $slide);
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
        $slide = Slide::find($id);
        $slide->created_by = $request->user_id;
        $slide->updated_by = $request->user_id;
        $slide->alt = $request->alt;
        $slide->link = $request->link;
        $slide->status = ($request->has('status') == true) ? 1 : 0;
        $slide->save();
        if ($request->hasFile('bannerfile'))
        {
            $slide->uploadImage($request->file('bannerfile'));
        }
        \Alert::success(trans('menu.slide') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/slides');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/slides' . $dreambook->id . '/edit');
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
        if ($request->has('type')){
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete')
            {
                Slide::whereIn('id', $id)->delete();
                $message = trans('menu.slide') . trans('trans.messagedeleted');
            }elseif ($type == 'remove'){
                Slide::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.slide') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        }else{
            Slide::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.slide') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        if ($status == '1') {
            $status = 0;
        }elseif ($status == '0') {
            $status = 1;
        }
        $statusup = Slide::find($id);
        $statusup->status = $status;
        $statusup->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.slide') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        Slide::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.slide') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.slide') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
