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
            $category = Category::select(['id', 'name', 'slug', 'banner', 'thumb', 'icon_class', 'status', 'image_view'])->orderBy('ordering', 'ASC')->orderBy('id', 'DESC');
            $datatables = Datatables::of($category)->addColumn('action', function ($category) {
                                $id = $category->id;
                                $entity = 'categories';
                                return view('backend.shared._actions', compact("id", "entity"));
                            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL. '/categories') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small>Slug: {{$slug}}</small>')
                            ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                        'data-id' => '{{$id}}'
                    ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'thumb_banner', 'status', 'check'])->addIndexColumn();
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
            'order' => [
                1,
                'ASC'
            ],
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
         $get_parent = Category::where('parent_id',0)->pluck('name','id')->prepend('Is parent', '0')->all();
         
         return view('backend.catalogs.category.create')->with('get_parent',$get_parent);
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
     \Alert::success('Category has been added successfully !!!', 'Success');
        return redirect(_ADMIN_PREFIX_URL. '/categories');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
