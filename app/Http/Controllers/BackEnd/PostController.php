<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Requests\PostsRequest;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Category;
use App\Models\BackEnd\Post;
use App\Models\BackEnd\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PostController extends Controller
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
            $post = Post::getAllRecord(0);
            $datatables = Datatables::of($post)->addColumn('action', function ($post) {
                $id = $post->id;
                $entity = 'posts';
                return view('backend.shared._actions', compact("id", "entity"));
            })->editColumn('name', '<a href="' . url(_ADMIN_PREFIX_URL . '/posts') . '/{{ $id }}/edit" >{{ $name }}</a><br/><small>Slug: {{$slug}}</small>')
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

        return view('backend.catalogs.post.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $get_parent = Category::where('parent_id', 277)->where('status', 1)->pluck('name', 'id')->all();
        return view('backend.catalogs.post.create')->with('get_parent', $get_parent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsRequest $request)
    {
        $post = new Post;
        $post->created_by = $request->user_id;
        $post->updated_by = $request->user_id;
        $post->name = $request->txtname;
        $post->category_id = $request->category_id;
        $post->slug = str::slug($request->txtslug);
        $post->description = $request->shortdesc;
        $post->status = ($request->has('status') == true) ? 1 : 0;
        $post->meta_key = $request->txtmetakey;

        $post->meta_desc = $request->txtmetadesc;
        $post->save();
        if ($request->hasFile('bannerfile')) {
            $post->uploadImage($request->file('bannerfile'));
        }

        \Alert::success(trans('menu.post') . trans('trans.messageaddsuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/posts');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/posts' . $post->id . '/edit');
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
        $post = Product::find($id);
        $get_parent = Category::where('status', 1)->where('parent_id', 277)->pluck('name', 'id')->all();
        return view('backend.catalogs.post.edit')->with('post', $post)->with('get_parent', $get_parent);
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
    public function destroy(Request $request, $id)
    {
        if ($request->has('type')) {
            $type = $request->input('type');
            $id = explode(',', $request->input('checkedid'));
            if ($type == 'delete') {
                Post::whereIn('id', $id)->delete();
                $message = trans('menu.post') . trans('trans.messagedeleted');
            } elseif ($type == 'remove') {
                Post::whereIn('id', $id)->update(['is_trashed' => 1, 'trashed_at' => \Carbon\Carbon::now()]);
                $message = trans('menu.post') . trans('trans.messagemovedtrashed');
            }

            return response()->json(['title' => trans('trans.success'), 'message' => $message, 'status' => 'success']);
        } else {
            Post::find($id)->delete();
            return response()->json(['title' => trans('trans.success'), 'message' => trans('menu.post') . trans('trans.messagedeleted'), 'status' => 'success', 'id' => 'id_' . $id]);
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

        $updateStatus = Post::find($id);
        $updateStatus->status = $status;
        $updateStatus->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => trans('menu.post') . trans('trans.messageupdatesuccess'), 'status' => $status, 'id' => $id, 'html' => $html]);

    }
}
