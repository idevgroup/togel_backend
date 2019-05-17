<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\Product;
use App\Http\Requests\ProductsRequest;
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
        if(request()->ajax()) {
            $product = Product::getAllRecord(0);
            $datatables = Datatables::of($product)->addColumn('action', function($product){
                                $product_id = $product->product_id;
                                $entity = 'products';
                                return view('backed.shared._actions', compact("id", "entity"));
            });
        }

        $html = $builder->columns([
                    ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span></label>', 'orderable' => false, "searchable" => false, 'width' => '40'],
                    // ['data' => 'ProductImage', 'name' => 'ProductImage', 'title' => 'ProductImage', 'orderable' => false, 'searchable' => false, 'width' => '80'],
                    // ['data' => 'ProductName', 'name' => 'ProductName', 'title' => 'ProductName', 'orderable' => false, 'searchable' => false, 'width' => '40'],
                    // ['data' => 'ProductLink', 'name' => 'ProductLink', 'title' => 'ProductLink', 'orderable' => false, 'searchable' => false, 'width' => '40'],
                    // ['data' => 'ProductCategory', 'name' => 'ProductCategory', 'title' => 'ProductCategory',, 'orderable' => false, 'searchable' => false, 'width' => '40'],
                    // ['data' => 'status', 'name' => 'status', 'title' => 'Status', "orderable" => false, "searchable" => false, 'width' => '40'],
                    // ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '60'],
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
