<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\Category;
use App\Http\Requests\CategoriesRequest;
use Illuminate\Support\Str;

class CategoryController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder) {
        if (request()->ajax()) {
            $category = Category::getAllRecord(0);
            $datatables = Datatables::of($category)->addColumn('action', function ($category) {
                                $id = $category->id;
                                $entity = 'categories';
                                return view('backend.shared._actions', compact("id", "entity"));
                            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/categories') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small>Slug: {{$slug}}</small>')
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
            'lengthMenu' => \Config::get('sysconfig.lengthMenu')
        ]);

        return view('backend.catalogs.category.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $get_parent = Category::where('parent_id', 0)->where('status', 1)->pluck('name', 'id')->prepend('Is parent', '0')->all();

        return view('backend.catalogs.category.create')->with('get_parent', $get_parent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriesRequest $request) {

        $category = new Category;
        $category->name = $request->input('txtname');
        $category->slug = Str::slug($request->input('txtslug'));
        $category->parent_id = $request->input('isparent');
        $category->description = $request->input('shortdesc');
        $category->status = ($request->has('status') == true) ? 1 : 0;
        $category->meta_key = $request->input('txtmetakey');
        $category->meta_desc = $request->input('txtmetadesc');
        $category->save();
        if ($request->hasFile('bannerfile')) {
            $category->uploadImage($request->file('bannerfile'));
        }
        \Alert::success(trans('menu.category') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/categories');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/categories/' . $category->id . '/edit');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $record = Category::findOrFail($id);
        $get_parent = $record->where('parent_id', 0)->where('status', 1)->pluck('name', 'id')->prepend('Is parent', '0')->all();
        return view('backend.catalogs.category.edit')->with('get_parent', $get_parent)->with('record', $record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, $id) {
        $category = Category::findOrFail($id);
        $category->name = $request->input('txtname');
        $category->slug = Str::slug($request->input('txtslug'));
        $category->parent_id = $request->input('isparent');
        $category->description = $request->input('shortdesc');
        $category->status = ($request->has('status') == true) ? 1 : 0;
        $category->meta_key = $request->input('txtmetakey');
        $category->meta_desc = $request->input('txtmetadesc');
        $category->save();
        if ($request->hasFile('bannerfile')) {
            $category->uploadImage($request->file('bannerfile'));
        }
        \Alert::success(trans('menu.category') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/categories');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/categories/' . $category->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id) {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                Category::whereIn('id', $id)->delete();
                $message = trans('menu.category') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                Category::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.category') . trans('trans.messagemovedtrashed');
            }

            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            Category::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.category') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request) {
        $status = $request->status;
        $id = $request->id;
        if ($status == '1') {
            $status = 0;
        } elseif ($status == '0') {
            $status = 1;
        }
        $update = Category::find($id);
        $update->status = $status;
        $update->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.category') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request) {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        $update = Category::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.category') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.category') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }

}
