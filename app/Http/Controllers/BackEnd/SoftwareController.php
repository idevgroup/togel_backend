<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\SoftwareRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Software;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Str;

class SoftwareController extends Controller
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
            $software = Software::getAllRecord(0);
            $datatables = Datatables::of($software)->addColumn('action', function ($software) {
                $id = $software->id;
                $entity = 'software';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/software') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small>Slug: {{$slug}}</small>')
                ->editColumn('description', '{!!$description!!}')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'description', 'thumb', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '
            <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> 
            <input type="checkbox" value="" class="m-group-checkable"> <span></span>
            </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'thumb', 'name' => 'thumb', 'title' => 'Image', "orderable" => false, "searchable" => false, 'width' => '80'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
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

        return view('backend.catalogs.software.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.catalogs.software.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SoftwareRequest $request)
    {
//        dd($request->all());
        $software = new Software;
        $software->created_by = $request->user_id;
        $software->updated_by = $request->user_id;
        $software->name = $request->name;
        $software->slug = str::slug($request->slug);
        $software->short_description = $request->shortdesc;
        $software->description = $request->desc;
        $software->status = ($request->has('status') == true) ? 1 : 0;
        $software->file = $request->filepath;
        $software->save();
        if ($request->hasFile('bannerfile')) {
            $software->uploadImage($request->file('bannerfile'));
        }


        \Alert::success(trans('menu.software') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/software');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/software' . $product->id . '/edit');
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
        $record = Software::find($id);
        return view('backend.catalogs.software.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SoftwareRequest $request, $id)
    {
        $software = Software::find($id);
        $software->created_by = $request->user_id;
        $software->updated_by = $request->user_id;
        $software->name = $request->name;
        $software->slug = str::slug($request->slug);
        $software->short_description = $request->short_description;
        $software->description = $request->description;
        $software->status = ($request->has('status') == true) ? 1 : 0;
        $software->file = $request->filepath;
        $software->save();
        if ($request->hasFile('bannerfile')) {
            $software->uploadImage($request->file('bannerfile'));
        }


        \Alert::success(trans('menu.software') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/software');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/software' . $product->id . '/edit');
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
        if ($request->has('type'))
        {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete')
            {
                Software::whereIn('id',$id)->delete();
                $message = trans('menu.software') . trans('trans.messagedeleted');
            }elseif ($type == 'remove'){
                Software::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => Carbon::now()]);
                $message = trans('menu.software') . trans('trans.messagemovedtrashed');
            }
            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        }else{
            Software::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.software') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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
        $statusup = Software::find($id);
        $statusup->status = $status;
        $statusup->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.software') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        Software::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.software') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.software') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
