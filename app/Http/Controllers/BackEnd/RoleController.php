<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Role;
use App\Models\BackEnd\UserMenu;
use Config;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
  
        // $qSelect = Role::get();
        if (request()->ajax()) {

            $roles = Role::select(['id', 'name', 'created_at']);
            $datatables = Datatables::of($roles)->addColumn('action', function () {return '';})->editColumn('action', function ($role) {
                $id = $role->id;
                $entity = 'usergroup';
                return view('backend.shared._actions',compact("id","entity"));
            })->editColumn('name', '<a href="' . url(Config::get('sysconfig.prefix') . '/usergroup') . '/{{ $id }}/edit" >{{ $name }}</a>')->rawColumns(['name', 'action'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_Row_Index', 'name' => 'DT_Row_Index', 'title' => 'No', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '60'],

        ])->parameters([
            'order' => [
                1,
                'ASC'
            ],
            'lengthMenu' => Config::get('sysconfig.lengthMenu')
            ]);
        return view('backend.role.index', compact('html'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $qSelectMenu = UserMenu::where('state', 1)->orderBy('ordering', 'ASC')->get();
        $arrMenu = [];

        foreach ($qSelectMenu->where('parent_id', 0) as $row) {
            foreach ($qSelectMenu->where('parent_id', $row->id) as $rowchild) {
                $arrMenu[trans("menu.$row->name")][$rowchild->id] = trans("menu.$rowchild->name");
            }
        }

        return view('backend.role.add', compact('arrMenu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'txtname' => 'bail|required|min:2',
            'menu' => 'required|min:1',
        ]);
        $role = new Role;
        $role->name = $request->txtname;
        $role->guard_name = 'web';
        $role->menu_access = implode(',', $request->menu);
        $role->save();
     \Alert::success('User group has been added successfully !!!', 'Success');

        return redirect(Config::get('sysconfig.prefix') . '/usergroup');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $qSelect = Role::find($id);
        $menuaccess = explode(',', $qSelect->menu_access);
        $qSelectMenu = UserMenu::where('state', 1)->orderBy('ordering', 'ASC')->get();
        $arrMenu = [];

        foreach ($qSelectMenu->where('parent_id', 0) as $row) {
            foreach ($qSelectMenu->where('parent_id', $row->id) as $rowchild) {
                $arrMenu[trans("menu.$row->name")][$rowchild->id] = trans("menu.$rowchild->name");
            }
        }
        return view('backend.role.edit', compact('qSelect', 'menuaccess', 'arrMenu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'txtname' => 'bail|required|min:2',
            'menu' => 'required|min:1',
        ]);
        $role = Role::find($id);
        $role->name = $request->txtname;
        $role->guard_name = 'web';
        $role->menu_access = '1,' . implode(',', $request->menu);
        $role->save();
       \Alert::success('User group has been updated successfully !!!', 'Success');
        return redirect(Config::get('sysconfig.prefix') . '/usergroup');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::find($id)->delete();
        return response()->json(['title' => 'Success', 'message' => 'User group has been deleted ', 'status' => 'success']);
    }
}
