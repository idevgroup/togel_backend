<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuSettingRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Category;
use App\Models\BackEnd\MenuSetting;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class MenuSettingController extends Controller
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
            $menusetting = MenuSetting::with('getParents')->select(['id', 'name', 'parents', 'url', 'type', 'new_window', 'alias', 'status', 'is_trashed', 'created_at'])
                ->where('is_trashed', 0)
                ->where('parents',0)
                //->groupBy('parents')
                ->get();

            // $menuSettingParents = MenuSetting::select(['id', 'name', 'parents','url','type','new_window','alias','status', 'is_trashed'])
            // ->where('parents', $id)->where('status', 1)->where('is_trashed',0)->get();
            $datatables = Datatables::of($menusetting)->addColumn('action', function ($menusetting) {
                $id = $menusetting->id;
                $entity = 'menusettings';
                return view('backend.shared._actions', compact("id", "entity"));
            })
                ->editColumn('name',

                    '
                            @if($parents == 0)
                                <a href="' . url(_ADMIN_PREFIX_URL . '/menusettings') . '/{{ $id }}/edit" >
                                    {{ $name }}
                                </a>
                            @else
                            <a href="' . url(_ADMIN_PREFIX_URL . '/menusettings') . '/{{ $id }}/edit" >
                                    <li class="fa fa-long-arrow-alt-right"></li>
                                    {{ $name }}
                                </a> <br/>
                                    <strong> Alias :</strong>
                                        <small> {{ $alias }}</small><br/>
                            @endif'
                )
                ->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowData([
                'data-id' => '{{$id}}',
            ])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['name', 'action', 'status', 'check'])->addIndexColumn();
            // dd($datatables);
            return $datatables->make(true);
        }

        $html = $builder->columns([
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],

            ['data' => 'status', 'name' => 'status', 'title' => trans('labels.status'), "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'action', 'name' => 'action', 'title' => trans('labels.action'), "orderable" => false, "searchable" => false, 'width' => '60'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'created', "orderable" => false, "searchable" => false, 'width' => '140'],
        ])->parameters([
            'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
            'pagingType' => 'full_numbers',
            'bFilter' => true,
            'bSort' => true,
            'order' => [
                3,
                'ASC',
            ],
            'rowGroup' => [
                'dataSrc' => ['parent_id'],
            ],
        ]);

        return view('backend.systemsetting.menusetting.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_parent = MenuSetting::where('parents', 0)->where('status', 1)->pluck('name', 'id')->prepend('No parent', '')->all();
        $get_sub_parent = MenuSetting::where('parents', '<>', 0)->where('status', 1)->pluck('name', 'id')->prepend('No sub parent', '')->all();
        $getCate = Category::where('parent_id', 0)->with(['getParents'])->where('status', 1)->where('is_trashed', 0)->get();
        $cateItems = ['0' => 'All'];
        // $cateItems = [];
        foreach ($getCate as $rows) {
            $parentArray = [];
            foreach ($rows->getParents as $row) {
                $parentArray[$row->id] = $row->name;
            }

            $cateItems[$rows->name] = $parentArray;
        }

        // $getCategory = Category::where('parent_id', '<>', 0)->with(['posts', 'products', 'dreambooks'])->get();

        // $arrayCollection =collect();
        // foreach ($getCategory as $item) {
        //     foreach ($item->products as $row) {
        //         $arrayCollection->push(['id' => $row->id, 'name' => $row->name, 'slug' => $row->slug,'category_id' => $item->id, 'thumb' => $item->thumb, 'created_at' => $item->created_at]);
        //     }
        //     foreach ($item->posts as $row) {
        //         $arrayCollection->push(['id' => $row->id, 'name' => $row->name, 'slug' => $row->slug,'category_id' => $item->id, 'thumb' => $item->thumb, 'created_at' => $item->created_at]);
        //     }
        //     foreach ($item->dreambooks as $row) {
        //         $arrayCollection->push(['id' => $row->id, 'name' => $row->name, 'slug' => $row->slug,'category_id' => $item->id, 'thumb' => $item->thumb, 'created_at' => $item->created_at]);
        //     }

        // }
        // dd($arrayCollection);

        return view('backend.systemsetting.menusetting.create')
            ->with('get_parent', $get_parent)
            ->with('get_sub_parent', $get_sub_parent)
            ->with('getCate', $getCate)
            ->with('cateItems', $cateItems)
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = [
            'name' => 'required',
            'type' => 'required',
            'url' => 'required',
            'category_id' => 'required',

        ];
        if ($request->input('type') === '1') {
            unset($request->url);
            unset($request->category_id);
            unset($request->text_cont);
            unset($data['url']);
            unset($data['category_id']);
            unset($data['text_cont']);
        } elseif ($request->input('type') === '2') {
            unset($request->text_cont);
            unset($request->category_id);
            unset($data['category_id']);
            unset($data['text_cont']);
        } elseif ($request->input('type') === '3') {
            unset($request->url);
            unset($request->category_id);
            unset($data['url']);
            unset($data['category_id']);
        } elseif ($request->input('type') === '4') {
            unset($request->url);
            unset($request->text_cont);
            unset($data['url']);
            unset($data['text_cont']);
        }

        $this->validate($request, $data);

        $text_cont = (!empty($request->text_cont) ? $request->text_cont : "0");

        $url = (!empty($request->url) ? $request->url : "0");

        $category_id = (!empty($request->category_id) ? $request->category_id : "0");

        $menuSetting = new MenuSetting;
        $menuSetting->name = $request->name;
        if ($request->input('subparents') == null) {
            $menuSetting->parents = $request->parents;
        } else {
            $menuSetting->parents = $request->subparents;
        }

        // $menuSetting->parents = $request->subparents;
        $menuSetting->new_window = ($request->has('newwindow') == true) ? 1 : 0;
        $menuSetting->alias = $request->alias;
        $menuSetting->status = ($request->has('status') == true) ? 1 : 0;
        $menuSetting->type = $request->type;
        $menuSetting->link_cont_id = $text_cont;
        $menuSetting->url = $url;
        $menuSetting->link_cat_id = $category_id;
        // dd($request->all());
        $menuSetting->save();
        \Alert::success(trans('menu.menusetting') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/menusettings');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/menusettings/' . $menuSetting->id . '/edit');
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

        $menusetting = MenuSetting::findOrFail($id);
        $get_parent = MenuSetting::where('parents', 0)->where('status', 1)->pluck('name', 'id')->prepend('No parent', '')->all();
        $get_sub_parent = MenuSetting::where('parents', '<>', 0)->where('status', 1)->pluck('name', 'id')->prepend('No sub parent', '')->all();
        $getCate = Category::where('parent_id', 0)->with(['getParents'])->where('status', 1)->where('is_trashed', 0)->get();
        $cateItems = ['0' => 'All'];
        // $cateItems = [];
        foreach ($getCate as $rows) {
            $parentArray = [];
            foreach ($rows->getParents as $row) {
                $parentArray[$row->id] = $row->name;
            }

            $cateItems[$rows->name] = $parentArray;
        }
        // dd($get_sub_parent);
        return view('backend.systemsetting.menusetting.edit')
            ->with('get_parent', $get_parent)
            ->with('get_sub_parent', $get_sub_parent)
            ->with('menusetting', $menusetting)
            ->with('cateItems',$cateItems);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuSettingRequest $request, $id)
    {

        $menuSetting = MenuSetting::findOrFail($id);
        $menuSetting->name = $request->name;
        if ($request->input('subparents')) {
            $menuSetting->parents = $request->subparents;
        } elseif ($request->input('parents')) {
            $menuSetting->parents = $request->parents;
        } else {
            $menuSetting->parents = 0;
        }

        // $menuSetting->parents = $request->subparents;
        $menuSetting->url = $request->url;
        $menuSetting->new_window = ($request->has('newwindow') == true) ? 1 : 0;
        $menuSetting->alias = $request->alias;
        $menuSetting->status = ($request->has('status') == true) ? 1 : 0;
        $menuSetting->type = ($request->has('type') == true) ? 1 : 0;
        $menuSetting->save();
        \Alert::success(trans('menu.menusetting') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/menusettings');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/menusettings/' . $menuSetting->id . '/edit');
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
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                MenuSetting::whereIn('id', $id)->delete();
                $message = trans('menu.frontmenu') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                MenuSetting::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.frontmenu') . trans('trans.messagemovedtrashed');
            }

            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            MenuSetting::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.frontmenu') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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
        $update = MenuSetting::find($id);
        $update->status = $status;
        $update->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.frontmenu') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request)
    {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        $update = MenuSetting::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.frontmenu') . trans('trans.messageactive'), 'status' => 'success']);
        } else {
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.frontmenu') . trans('trans.messageunactive'), 'status' => 'warning']);
        }
    }

    public function getsubparent(Request $request)
    {
        if ($request->ajax()) {
            // dd($request->all());
            $parents = $request->input('parents');
            $getSubParent = MenuSetting::where('parents', $parents)->pluck('name', 'id')->all();
            //dd($getSubParent);
            return response()->json($getSubParent);
        }
    }

    public function showSingleCon()
    {
        $catSingleCon = request()->get('catSingleCon');

        $getCategory = Category::where('parent_id', '<>', 0)->with(['posts', 'products', 'dreambooks'])->where('status', 1)->get();

        $arrayCollection = collect();
        foreach ($getCategory as $item) {
            foreach ($item->products as $row) {
                $arrayCollection->push(['id' => $row->id, 'name' => $row->name, 'slug' => $row->slug, 'category_id' => $item->id, 'category_name' => $item->name, 'thumb' => $item->thumb, 'created_at' => $item->created_at]);
            }
            foreach ($item->posts as $row) {
                $arrayCollection->push(['id' => $row->id, 'name' => $row->name, 'slug' => $row->slug, 'category_id' => $item->id, 'category_name' => $item->name, 'thumb' => $item->thumb, 'created_at' => $item->created_at]);
            }
            foreach ($item->dreambooks as $row) {
                $arrayCollection->push(['id' => $row->id, 'name' => $row->name, 'slug' => $row->slug, 'category_id' => $item->id, 'category_name' => $item->name, 'thumb' => $item->thumb, 'created_at' => $item->created_at]);
            }
        }
        // return json_encode($arrayCollection);

        return Datatables::of($arrayCollection)
            ->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')
            ->editColumn('name', '<a href="javascript:void(0)" class="a" data-name="{{$name}}" data-id="{{$id}}"><h6>{!! $name !!}</h6></a>')
            ->rawColumns(['thumb', 'name'])
            ->make(true);

        //   return Datatables::of(Category::where('parent_id','<>', 0)->with(['posts'=>function($post) use($catSingleCon){
        //         // dd($post->get());
        //         if($catSingleCon === 0){
        //             return $post->where('status',1)->where('trashed_at',0)->get();
        //         }else {
        //             return $post->where('category_id', $catSingleCon)->where('status',1)->where('trashed_at',0)->get();
        //         }
        // },'products','dreambooks']))
        // ->editColumn('thumb', '{!!_CheckImage($thumb,_IMG_DEFAULT,["class" => "img-fluid"])!!}')
        // ->editColumn('name', '<h5>{!! $name !!}</h5>')
        // ->rawColumns(['thumb','name'])
        // ->make(true);
    }
}
