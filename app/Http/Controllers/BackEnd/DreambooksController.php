<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\dreambooksRequest;
use App\Models\BackEnd\Category;
use App\Models\BackEnd\DreamBooks;
use App\Models\BackEnd\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;

class DreambooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $dreambook = DreamBooks::getAllRecord(0);
            $datatables = Datatables::of($dreambook)->addColumn('action', function ($dreambook) {
                $id = $dreambook->id;
                $entity = 'dreambooks';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/dreambooks') . '/{{$id}}/edit">{{ $name }}</a><br/><small>Slug: {{ $slug }}</small>')
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
            ['data' => 'thumb', 'name' => 'thumb', 'title' => 'ProductImage', 'orderable' => false, 'searchable' => false, 'width' => '80'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
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

        return view('backend.catalogs.dreambook.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_parent = Category::where('parent_id', 280)->where('status', 1)->pluck('name', 'id')->all();
        return view('backend.catalogs.dreambook.create')->with('get_parent', $get_parent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(dreambooksRequest $request)
    {
        $dreambook = new DreamBooks;
        $dreambook->name = $request->txtname;
        $dreambook->created_by = $request->user_id;
        $dreambook->updated_by = $request->user_id;
        $dreambook->category_id = $request->category_id;
        $dreambook->slug = str::slug($request->txtslug);
        $dreambook->description = $request->shortdesc;
        $dreambook->status = ($request->has('status') == true) ? 1 : 0;
        $dreambook->meta_key = $request->txtmetakey;

        $dreambook->meta_desc = $request->txtmetadesc;
        $dreambook->save();
        if ($request->hasFile('bannerfile')) {
            $dreambook->uploadImage($request->file('bannerfile'));
        }

        \Alert::success(trans('menu.post') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/posts');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/posts' . $dreambook->id . '/edit');
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
        $dreambook = DreamBooks::find($id);
        $get_parent = Category::where('status', 1)->where('parent_id',277)->pluck('name', 'id')->all();
        return view('backend.catalogs.dreambook.edit')->with('dreambook', $dreambook)->with('get_parent', $get_parent);
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
//        $dreambook = new DreamBooks;
//        $dreambook->name = $request->txtname;
//        $dreambook->created_by = $request->user_id;
//        $dreambook->updated_by = $request->user_id;
//        $dreambook->category_id = $request->category_id;
//        $dreambook->slug = str::slug($request->txtslug);
//        $dreambook->description = $request->shortdesc;
//        $dreambook->status = ($request->has('status') == true) ? 1 : 0;
//        $dreambook->meta_key = $request->txtmetakey;
//
//        $dreambook->meta_desc = $request->txtmetadesc;
//        $dreambook->save();
//        if ($request->hasFile('bannerfile')) {
//            $dreambook->uploadImage($request->file('bannerfile'));
//        }
//
//        \Alert::success(trans('menu.post') . trans('trans.messageaddsuccess'), trans('trans.success'));
//        if ($request->has('btnsaveclose')) {
//            return redirect(_ADMIN_PREFIX_URL . '/posts');
//        } else {
//            return redirect(_ADMIN_PREFIX_URL . '/posts' . $dreambook->id . '/edit');
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
