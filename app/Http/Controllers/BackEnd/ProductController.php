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
                $id = $product->product_id;
                $entity = 'products';
                return view('backed.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/products') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small>Slug: {{$slug}}</small>')
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                    'data-id' => '{{$id}}'
                ])->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'thumb', 'status', 'check'])->addIndexColumn();
            return $datatables->make(true);

        }

        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span></label>', 'orderable' => false, "searchable" => false, 'width' => '40'],
             ['data' => 'ProductImage', 'name' => 'ProductImage', 'title' => 'ProductImage', 'orderable' => false, 'searchable' => false, 'width' => '80'],
             ['data' => 'ProductName', 'name' => 'ProductName', 'title' => 'ProductName', 'orderable' => false, 'searchable' => false, 'width' => '40'],
             ['data' => 'ProductLink', 'name' => 'ProductLink', 'title' => 'ProductLink', 'orderable' => false, 'searchable' => false, 'width' => '40'],
//             ['data' => 'ProductCategory', 'name' => 'ProductCategory', 'title' => 'ProductCategory',, 'orderable' => false, 'searchable' => false, 'width' => '40'],
             ['data' => 'status', 'name' => 'status', 'title' => 'Status', "orderable" => false, "searchable" => false, 'width' => '40'],
             ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '60'],
        ])->parameters([
            'lengthMenu' => \Config::get('sysconfig.lengthMenu')
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
//        $get_parent = Category::where('parent_id', 0)->where('status', 1)->where('id', 273)->pluck('name', 'id')->prepend('Is parent', '0')->all();
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
        $product->status = $request->status;
        $product->meta_key = $request->txtmetakey;
        $product->meta_desc = $request->txtmetadesc;

        if ($request->hasFile('bannerfile')) {
            $product->uploadImage($request->file('bannerfile'));
        }
        $product->save();
        \Alert::success(trans('menu.category') . trans('trans.messageaddsuccess'), trans('trans.success'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
