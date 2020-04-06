<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Role;
use App\Model\Permission;
use DB;

class PermissionController extends AdminController {

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
            $permission_edit = $permission_delete = $permission_create = 1;
        } else {
            $permission_edit = $permission_delete = $permission_create = 0;
        }
        $data = Permission::orderBy('id', 'DESC')->paginate($this->limit);
        $type_action = 'الصلاحية';
        return view('admin.permissions.index', compact('type_action', 'data', 'permission_create', 'permission_delete', 'permission_edit'))->with('i', ($request->input('page', 1) - 1) * 5);
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
//        $permission = Permission::pluck('display_name', 'id');
        $link_return = route('admin.permission.index');
        return view('admin.permissions.create', compact('link_return'));
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
        $all_access = Permission::where('id', 1)->first();
        if (!isset($all_access->id)) {
            $access_input = [
                'name' => 'access-all',
                'display_name' => 'كل الصلاحيات',
                'description' => 'جميع العميات متاح من اجله'
            ];
            $admin_access = Permission::create($access_input);
        }
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
        ]);
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "description") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $name = $input['name'];
        $display_name = $input['display_name'];
        $admin = Permission::create($input);

        $array_item = ['add' => 'اضافة', 'update' => 'تعديل', 'delete' => 'حذف', 'show' => 'مشاهدة', 'display' => 'عرض'];
        $input['parent_id'] = $admin['id'];
        $input['description'] = null;
        foreach ($array_item as $key => $value) {
            $input['name'] = $key . '_' . $name;
            $input['display_name'] = $value . ' ' . $display_name;
            $admin = Permission::create($input);
        }
        return redirect()->route('admin.permission.index')->with('success', 'Permission created successfully');
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
        $permission = Permission::find($id);
        if (!empty($permission)) {
            return view('admin.permissions.show', compact('permission'));
        } else {
            return $this->pageError();
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
        $permission = Permission::findOrFail($id);
        if (!empty($permission)) {
            $link_return = route('admin.permission.index');
            return view('admin.permissions.edit', compact('link_return', 'permission', 'permission', 'permissionPermissions'));
        } else {
            return $this->pageError();
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
        $permission = Permission::find($id);
        if (!empty($permission)) {
            $this->validate($request, [
                'name' => 'required',
                'display_name' => 'required',
//                'permission' => 'required',
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "description") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
            $input['name']=$permission->name;
            $permission->update($input);
            return redirect()->route('admin.permission.index')->with('success', 'Permission updated successfully');
        } else {
            return $this->pageError();
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
        $permission = Permission::find($id);
        if (isset($permission->id)) {
            if ($permission->id == 1) {
                return redirect()->route('admin.permission.index')->with('error', 'Role deleted successfully');
            } else {
                $permission->delete();
                return redirect()->route('admin.permission.index')->with('success', 'Role deleted successfully');
            }
        } else {
            return $this->pageError();
        }
    }

    public function search() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $permission_edit = $permission_delete = $permission_create = 0;

        if ($this->user->can('access-all')) {
            $permission_edit = $permission_delete = $permission_create = 1;
        }
        $type_action = 'الصلاحية';
        $data = Permission::orderBy('id', 'DESC')->get();
        return view('admin.permissions.search', compact('type_action', 'data', 'permission_create', 'permission_delete', 'permission_edit'));
    }

}
