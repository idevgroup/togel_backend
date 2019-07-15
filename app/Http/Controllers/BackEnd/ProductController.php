<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\ProductsRequest;
use App\Models\BackEnd\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
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
            $product = Product::getAllRecord(0);
            $datatables = Datatables::of($product)->addColumn('action', function ($product) {
                $id = $product->id;
                $entity = 'products';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/products') . '/{{$id}}/edit">{{ $name }}</a><br/><small>Slug: {{ $slug }}</small>')
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
            ['data' => 'thumb', 'name' => 'thumb', 'title' => trans('labels.image'), 'orderable' => false, 'searchable' => false, 'width' => '80'],
            ['data' => 'name', 'name' => 'name', 'title' => trans('labels.productname')],
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

        return view('backend.catalogs.product.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_parent = Category::where('parent_id', 273)->where('status', 1)->pluck('name', 'id')->all();
        return view('backend.catalogs.product.create')->with('get_parent', $get_parent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'txtname' => 'required|min:4',
            'txtslug' => 'required|min:1|unique:product,slug,'
        ], ['txtname.required' => 'Please input Product Name',
            'txtname.unique' => 'The Product name as already been taken',
            'txtslug.required' => 'Please input slug']);
        $product = new Product;
        $product->name = $request->txtname;
        $product->created_by = $request->user_id;
        $product->updated_by = $request->user_id;
        $product->category_id = $request->category_id;
        $product->slug = str::slug($request->txtslug);
        $product->description = $request->shortdesc;
        $product->status = ($request->has('status') == true) ? 1 : 0;
        $product->meta_key = $request->txtmetakey;
        $product->meta_desc = $request->txtmetadesc;
//        $product->is_trashed = 0;
        if ($request->hasFile('bannerfile')) {
            $product->uploadImage($request->file('bannerfile'));
        }
        $product->save();
        \Alert::success(trans('menu.product') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/products');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/products' . $product->id . '/edit');
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
        $product = Product::find($id);
        $get_parent = Category::where('status', 1)->where('parent_id',273)->pluck('name', 'id')->all();
        return view('backend.catalogs.product.edit')->with('product', $product)->with('get_parent', $get_parent);
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
        $request->validate([
            'txtname' => 'required|min:4',
            'txtslug' => 'required|min:1'
        ], ['txtname.required' => 'Please input Product Name',
            'txtname.unique' => 'The Product name as already been taken',
            'txtslug.required' => 'Please input slug']);
        $product = Product::findOrfail($id);
        $product->name = $request->txtname;
        $product->created_by = $request->user_id;
        $product->updated_by = $request->user_id;
        $product->category_id = $request->category_id;
        $product->slug = str::slug($request->txtslug);
        $product->description = $request->shortdesc;
        $product->status = ($request->has('status') == true) ? 1 : 0;
        $product->meta_key = $request->txtmetakey;
        $product->meta_desc = $request->txtmetadesc;

        $product->save();
        if ($request->hasFile('bannerfile')) {
            $product->uploadImage($request->file('bannerfile'));
        }
        \Alert::success(trans('menu.category') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/products');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/products' . $product->id . '/edit');
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
                Product::whereIn('id', $id)->delete();
                $message = trans('menu.product') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                Product::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.product') . trans('trans.messagemovedtrashed');
            }

            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            Product::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.category') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
        }
    }

    public function checkStatus(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        if ($status == '1') {
            $status = 0;
        } elseif ($status == '0') {
            $status = 1;
        }
        $update = Product::find($id);
        $update->status = $status;
        $update->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.category') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request) {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        $update = Product::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.product') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.product') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }
}
