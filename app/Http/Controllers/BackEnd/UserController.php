<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\Authorizable;
use App\Models\BackEnd\Permission;
use App\Models\BackEnd\Role;
use App\Models\BackEnd\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use Alert;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class UserController extends Controller {

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder) {
        if (request()->ajax()) {
            $users = User::select(['id', 'name', 'email', 'created_at', 'status', 'username'])->with('roles')->where('id', '<>', 28);
            $datatables = Datatables::of($users)->addColumn('roles', function (User $user) {
                                return $user->roles ? $user->roles->implode('name', ', ') : '';
                            })->addColumn('action', function ($role) {
                                $id = $role->id;
                                $entity = 'useraccounts';
                                return view('backend.shared._actions', compact("id", "entity"));
                            })->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                     @if(Auth::user()->id != $id) <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span> @endif
                    </label>')->editColumn('status', '<div id="action_{{$id}}" @if(Auth::user()->id == $id) class="d-none"  @endif>{!!_CheckStatus($status,$id)!!}</div>')->rawColumns(['name', 'check', 'status', 'action', 'email'])
                            ->setRowId('id_{{$id}}')->editColumn('name', function($query) {
                        if ($query->isOnline()) {
                            return $query->name . ' <span class=" m-badge m-badge--dot m-badge--success"></span>';
                        } else {
                            return $query->name;
                        }
                    })->editColumn('email', '<span class="user-name">{{$username}}</span><span class="user-name">{{$email}}</span>');

            return $datatables->make(true);
        }
        $html = $builder->columns([
                    ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
                    ['data' => 'name', 'name' => 'name', 'title' => trans('labels.name')],
                    ['data' => 'email', 'name' => 'email', 'title' => trans('labels.username').'/'.trans('labels.email')],
                    ['data' => 'roles', 'name' => 'roles', 'title' => trans('labels.rolename')],
                    ['data' => 'status', 'name' => 'status', 'title' => trans('labels.status'), "orderable" => false, "searchable" => false, 'width' => '40'],
                    ['data' => 'action', 'name' => 'action', 'title' => trans('labels.action'), "orderable" => false, "searchable" => false, 'width' => '40'],
                ])->parameters([
            'order' => [
                1,
                'ASC'
            ],
            'lengthMenu' => Config::get('sysconfig.lengthMenu')
        ]);
        return view('backend.user.index', compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::where('status', 1)->pluck('name', 'id');
        return view('backend.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'username' => 'required|string|max:255|min:3|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6',
            'roles' => 'required|min:1',
        ]);
        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);
        // Create the user
        if ($user = User::create($request->except('roles', 'permissions'))) {
            $this->syncPermissions($request, $user);
            Alert::success('User has been added successfully !!!', 'Success')->persistent("OK");
        } else {
            Alert::error('Unable to create user !!!', 'Error')->persistent("OK");
        }

        return redirect()->route(Config::get('sysconfig.prefix') . 'useraccounts.index');
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
        $user = User::find($id);
        $roles = Role::pluck('name', 'id');
        $permissions = Permission::all('name', 'id');

        return view('backend.user.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'bail|required|min:2',
            'username' => 'required|string|max:255|min:3|unique:users,username,' . $id,
            'email' => 'required|string|email|unique:users,email,' . $id,
            'roles' => 'required|min:1',
        ]);

        // Get the user
        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password', 'status'));

        // check for password change
        //  if ($request->get('password')) {
        //  $user->password = bcrypt($request->get('password'));
        // }
        // Handle the user roles
        $this->syncPermissions($request, $user);

        $user->save();
        if ($request->has('password')) {
            // $user->password = bcrypt($request->get('password'));
            Auth::logoutOtherDevices($request->get('password'));
        }
        Alert::success('User has been updated successfully !!!', 'Success')->persistent("OK");

        return redirect()->route(Config::get('sysconfig.prefix') . 'useraccounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id) {
        if (Auth::user()->id == $id) {
            return response()->json(['title' => 'Deletion of currently', 'message' => 'Deletion of currently logged in user is not allowed ', 'status' => 'info']);
        }

        if (User::findOrFail($id)->delete()) {
            //flash()->success('User has been deleted');
            return response()->json(['title' => 'Success', 'message' => 'User has been deleted ', 'status' => 'success', 'id' => 'id_' . $id]);
        } else {
            return response()->json(['title' => 'Not Completed', 'message' => 'User has no deleted ', 'status' => 'warning', 'id' => 'id_' . $id]);
        }

        //return redirect()->back();
    }

    /**
     * Sync roles and permissions
     *
     * @param Request $request
     * @param $user
     * @return string
     */
    private function syncPermissions(Request $request, $user) {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if (!$user->hasAllRoles($roles)) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        return $user;
    }

    public function checkStatus(Request $request) {
        $status = $request->status;
        $id = $request->id;
        if ($status == '1') {
            $status = 0;
        } elseif ($status == '0') {
            $status = 1;
        }
        $update = User::find($id);
        $update->status = $status;
        $update->save();
        $html = _CheckStatus($status, $id);
        return response()->json(['message' => 'User Account has been updated', 'status' => $status, 'id' => $id, 'html' => $html]);
    }

    public function checkMultiple(Request $request) {
        $id = explode(',', $request->input('checkedid'));
        $status = $request->input('status');
        $update = User::whereIn('id', $id)->update(['status' => $status]);
        if ($status == 1) {
            return response()->json(['title' => 'Success', 'message' => 'User Account has been actived ', 'status' => 'success']);
        } else {
            return response()->json(['title' => 'Success', 'message' => 'User Account has been unactive ', 'status' => 'warning']);
        }
    }

}
