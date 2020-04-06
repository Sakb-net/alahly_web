<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permission;
use DB;

class RoleController_old extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        if ($this->user->can('access-all')) {
            $role_edit = $role_delete = $role_create = 1;
        } else {
            $role_edit = $role_delete = $role_create = 0;
        }
        $data = Role::orderBy('id', 'DESC')->paginate($this->limit);
        $type_action = '';
        return view('admin.roles.index', compact('type_action', 'data', 'role_create', 'role_delete', 'role_edit'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $permission = Permission::pluck('display_name', 'id');
        $rolePermissions = [];
        $link_return = route('admin.roles.index');
        return view('admin.roles.create', compact('link_return', 'permission', 'rolePermissions'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
//            'permission' => 'required',
        ]);
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "permission") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $role = new Role();
        $role->name = $input['name'];
        $role->display_name = $input['display_name'];
        $role->description = $input['description'];
        $role->save();
//        $role = Role::create($input);

        if (!empty($request->input('permission'))) {
            foreach ($request->input('permission') as $key => $value) {
                $role->attachPermission(stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING))));
            }
        }
        session()->put('success', trans('app.save_success'));
        return redirect()->route('admin.roles.index');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show($id) {

        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $role = Role::find($id);

        if (!empty($role)) {

            $rolePermissions = Permission::join("permission_role", "permission_role.permission_id", "=", "permissions.id")->where("permission_role.role_id", $id)->get();
            return view('admin.roles.show', compact('role', 'rolePermissions'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $role = Role::find($id);

        if (!empty($role)) {

            $permission = Permission::pluck('display_name', 'id');
            $rolePermissions = $role->permissions->pluck('id', 'id')->toArray();
            $link_return = route('admin.roles.index');
            return view('admin.roles.edit', compact('link_return', 'role', 'permission', 'rolePermissions'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function update(Request $request, $id) {

        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $role = Role::find($id);

        if (!empty($role)) {
            $this->validate($request, [
                'name' => 'required|unique:roles,name,' . $id,
                'display_name' => 'required',
//                'permission' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "permission") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

            $role->name = $input['name'];
            $role->display_name = $input['display_name'];
            $role->description = $input['description'];
            $role->save();
//            $role->update($input);

            if ($id != 1) {
                DB::table("permission_role")->where("permission_role.role_id", $id)->delete();
                if (!empty($request->input('permission'))) {
                    foreach ($request->input('permission') as $key => $value) {
                        $role->attachPermission(stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING))));
                    }
                }
            }
            session()->put('success', trans('app.update_success'));
            return redirect()->route('admin.roles.index');
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function destroy($id) {

        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $role = Role::find($id);
        if (!empty($role)) {
            if ($id != 1) {
                Role::find($id)->delete();
                session()->put('success', trans('app.delete_success'));
                return redirect()->route('admin.roles.index');
            } else {
                session()->put('error', trans('app.delete_failed'));
                return redirect()->route('admin.roles.index');
            }
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function search() {


        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $role_edit = $role_delete = $role_create = 0;

        if ($this->user->can('access-all')) {
            $role_edit = $role_delete = $role_create = 1;
        }
        $type_action = '';
        $data = Role::orderBy('id', 'DESC')->get();
        return view('admin.roles.search', compact('type_action', 'data', 'role_create', 'role_delete', 'role_edit'));
    }

}
