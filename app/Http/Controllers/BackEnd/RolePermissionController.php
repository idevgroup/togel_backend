<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\RolePermission;
use App\Models\BackEnd\Role;
use App\Models\BackEnd\UserMenu;
use App\Models\BackEnd\Permission;
use App\Models\BackEnd\Authorizable;
class RolePermissionController extends Controller {
     use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $roles = Role::where('status', 1)->pluck('name', 'id')->prepend('Select Role', '');
        return view('backend.rolepermission.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $getRole = Role::findOrFail($id);
        $arrRoleId = explode(',', $getRole->menu_access);
        $getMenuAccess = UserMenu::whereIn('id', $arrRoleId)->where('state', 1)->get();
        $getAllPermission = new Permission;
        $arrPermission = [];
        foreach ($getMenuAccess as $list) {
            $getUrl = trim($list->url);
            $ltrim = ltrim($getUrl, '/');
            $getPermission = $getAllPermission->where('name', 'LIKE', '%' . $ltrim)->pluck('name', 'id');
            $arrPermission[trans('menu.' . $list->name)] = $getPermission;
        }
        $viewRender = view('backend.rolepermission.permissionlist', compact('arrPermission', 'getRole'))->render();
        return response()->json(['permisionHtml' => $viewRender]);
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
        if ($role = Role::findOrFail($id)) {
            $permissions = $request->get('permissions', []);
            $role->syncPermissions($permissions);
            return response()->json(['title' => 'Success', 'message' => 'Role permission has been updated ', 'status' => 'success']);
        }
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
