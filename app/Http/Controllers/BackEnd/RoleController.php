<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Role;
use App\Models\BackEnd\UserMenu;
use Config;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;
use App\Models\BackEnd\Authorizable;

class RoleController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder) {

        if (request()->ajax()) {

            $roles = Role::select(['id', 'name', 'created_at', 'status']);
            $datatables = Datatables::of($roles)->addColumn('action', function ($role) {
                        $id = $role->id;
                        $entity = 'rolegroups';
                        return view('backend.shared._actions', compact("id", "entity"));
                    })->editColumn('name', '<a href="' . url(Config::get('sysconfig.prefix') . '/rolegroups') . '/{{ $id }}/edit" >{{ $name }}</a>')->rawColumns(['name', 'action', 'check', 'status'])->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->editColumn('status', '<div id="action_{{$id}}">{!!_CheckStatus($status,$id)!!}</div>')->setRowId('id_{{$id}}')->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
                    ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
                    ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
                    ['data' => 'status', 'name' => 'status', 'title' => 'Status', "orderable" => false, "searchable" => false, 'width' => '40'],
                    ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '40'],
                ])->parameters([
            'order' => [
                1,
                'ASC'
            ],
            'lengthMenu' => Config::get('sysconfig.lengthMenu')
        ]);
        return view('backend.rolegroup.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $qSelectMenu = UserMenu::where('state', 1)->orderBy('ordering', 'ASC')->get();
        $arrMenu = [];

        foreach ($qSelectMenu->where('parent_id', 0) as $row) {
            foreach ($qSelectMenu->where('parent_id', $row->id) as $rowchild) {
                $arrMenu[trans("menu.$row->name")][$rowchild->id] = trans("menu.$rowchild->name");
            }
        }

        return view('backend.rolegroup.create')->with('arrMenu', $arrMenu);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'rolename' => 'bail|required|min:2',
            'menu' => 'required|min:1',
        ]);
        $role = new Role;
        $role->name = $request->rolename;
        $role->guard_name = 'web';
        $role->menu_access = '1,' . implode(',', $request->menu);
        $role->status = ($request->has('status') == true) ? 1 : 0;
        $role->save();
        \Alert::success('Role group has been added successfully !!!', 'Success');

        return redirect(Config::get('sysconfig.prefix') . '/rolegroups');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $qSelect = Role::find($id);
        $menuaccess = explode(',', $qSelect->menu_access);
        $qSelectMenu = UserMenu::where('state', 1)->orderBy('ordering', 'ASC')->get();
        $arrMenu = [];

        foreach ($qSelectMenu->where('parent_id', 0) as $row) {
            foreach ($qSelectMenu->where('parent_id', $row->id) as $rowchild) {
                $arrMenu[trans("menu.$row->name")][$rowchild->id] = trans("menu.$rowchild->name");
            }
        }
        return view('backend.rolegroup.edit')
                        ->with('qSelect', $qSelect)
                        ->with('menuaccess', $menuaccess)
                        ->with('arrMenu', $arrMenu);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'rolename' => 'bail|required|min:2',
            'menu' => 'required|min:1',
        ]);
        $role = Role::find($id);
        $role->name = $request->rolename;
        $role->guard_name = 'web';
        $role->menu_access = '1,' . implode(',', $request->menu);
        $role->status = ($request->has('status') == true) ? 1 : 0;
        $role->save();
        \Alert::success('Role group has been updated successfully !!!', 'Success');
        return redirect(Config::get('sysconfig.prefix') . '/rolegroups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BackEnd\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        Role::find($id)->delete();
        return response()->json(['title' => 'Success', 'message' => 'User group has been deleted ', 'status' => 'success', 'id' => 'id_' . $id]);
    }

    public function checkStatus(Request $request) {
        $status = $request->status;
        $id = $request->id;
        if ($status == '1') {
            $status = 0;
        } elseif ($status == '0') {
            $status = 1;
        }
        $update = Role::find($id);
        $update->status = $status;
        $update->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => 'Role group has been updated', 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request) {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        $update = Role::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => 'Success', 'message' => 'Role group has been actived ', 'status' => 'success']);
        } else {
            return response()->json(['title' => 'Success', 'message' => 'Role group has been unactive ', 'status' => 'warning']);
        }
    }

}
