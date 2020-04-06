<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\UserMeta;
use App\Model\Post;
use App\Model\Role;
use DB;
use Hash;
use Auth;

class UserController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'user*'])) {
            return $this->pageUnauthorized();
        }

        $user_role = $user_edit = $user_delete = $user_create = $user_access = $user_show = 0;

        if ($this->user->can(['access-all', 'user-all'])) {
            $user_role = $user_edit = $user_delete = $user_create = $user_show = 1;
        }

        if ($this->user->can(['access-all'])) {
            $user_access = 1;
        }

        if ($this->user->can('user-delete')) {
            $user_delete = 1;
        }

        if ($this->user->can('user-show')) {
            $user_show = 1;
        }

        if ($this->user->can('user-edit')) {
            $user_edit = 1;
        }

        if ($this->user->can('user-create')) {
            $user_create = 1;
        }

        $data = User::orderBy('id', 'DESC')->paginate($this->limit);
        $type_action = 'المستخدم';
        return view('admin.users.index', compact('type_action', 'data', 'user_access', 'user_create', 'user_role', 'user_show', 'user_edit', 'user_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'user-all', 'user-create', 'user-edit'])) {
            return $this->pageUnauthorized();
        }
        $roles = Role::pluck('display_name', 'id');
        $userRole = $stateSend = [];
        $image = $confirm_password=NULL;
        $new = 1;
        $link_return = route('admin.users.index');
        return view('admin.users.create', compact('confirm_password','new', 'stateSend', 'link_return', 'roles', 'image', 'userRole'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'user-all', 'user-create', 'user-edit'])) {
            if ($this->user->can('user-list')) {
                return redirect()->route('admin.users.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255|unique:users,name',
            'email' => 'required|max:255|email|unique:users,email',
            'phone' => 'max:50',
            'password' => 'required|min:8|same:confirm-password',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "roles") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $input['password'] = Hash::make($input['password']);

        if (!isset($input['is_active'])) {
            $user_active = DB::table('options')->where('option_key', 'user_active')->value('option_value');
            $input['is_active'] = is_numeric($user_active) ? $user_active : 0;
        }

        foreach ($input as $key => $value) {
            $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
        }

        $user = User::create($input);
        if ($this->user->can(['access-all', 'user-all'])) {
            if (!empty($request->input('roles'))) {
                foreach ($request->input('roles') as $key => $value) {
                    $user->attachRole(stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING))));
                }
            }
        }
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show($id) {

        $user = User::find($id);
        if (!empty($user)) {
            if ($this->user->id != $id) {
                if (!$this->user->can(['access-all', 'user-all', 'user-edit', 'user-show'])) {
                    if ($this->user->can(['user-list', 'user-create'])) {
                        return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }
            $image =$user->image;
            $type_action = 'المستخدم';
            return view('admin.users.show', compact('image','user', 'type_action'));
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

        $user = User::find($id);
        if (!empty($user)) {
            if ($id == 1 && $this->user->id != 1) {
                if ($this->user->can(['user-all', 'user-list'])) {
                    return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            if ($this->user->id != $id) {
                if (!$this->user->can(['access-all', 'user-all', 'user-edit'])) {
                    if ($this->user->can(['user-list', 'user-create'])) {
                        return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            $roles = Role::pluck('display_name', 'id');
            $userRole = $user->roles->pluck('id', 'id')->toArray();
            $image = $user->image;
            $confirm_password = $user->password;
            $new = 0;
            $link_return = route('admin.users.index');
            return view('admin.users.edit', compact('confirm_password','new', 'link_return', 'user', 'roles', 'userRole', 'image'));
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

        $user = User::find($id);

        if (!empty($user)) {
            if ($id == 1 && $this->user->id != 1) {
                if ($this->user->can(['user-list', 'user-create', 'user-edit'])) {
                    return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            if ($this->user->id != $id) {
                if (!$this->user->can(['access-all', 'user-all', 'user-edit'])) {
                    if ($this->user->can('user-list')) {
                        return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            $this->validate($request, [
                'name' => 'required|max:255|unique:users,name,' . $id,
                'email' => 'required|max:255|email|unique:users,email,' . $id,
                'phone' => 'max:50',
//                'password' => 'same:confirm-password',
            ]);

            if ($user->id == Auth::user()->id && !empty($input['confirm-password'])) {
                $this->validate($request, [
                    'password' => 'same:confirm-password',
                ]);
            }
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "roles") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
//            if ($user->id == Auth::user()->id && !empty($input['confirm-password'])) {
                if (!empty($input['password'])) {

                    $input['password'] = Hash::make($input['password']);
                } else {

                    $input = array_except($input, array('password'));
                }
//            }else{
//                $input = array_except($input, array('password'));
//            }

            if ($id == 1) {
                $input['is_active'] = 1;
            }
            $user->update($input);

            if ($this->user->can(['access-all', 'user-all'])) {
                if ($id != 1) {
                    DB::table('role_user')->where('user_id', $id)->delete();

                    if (!empty($request->input('roles'))) {
                        foreach ($request->input('roles') as $key => $value) {
                            $user->attachRole(stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING))));
                        }
                    }
                }
            }

            return redirect()->route('admin.users.index')
                            ->with('success', 'User updated successfully');
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

        $user = User::find($id);

        if (!empty($user)) {
            if ($id == 1) {
                if ($this->user->can(['user-all', 'user-list'])) {
                    return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            if (!$this->user->can(['access-all', 'user-all', 'user-delete'])) {
                if ($this->user->can('user-list')) {
                    return redirect()->route('admin.users.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            User::find($id)->delete();

            return redirect()->route('admin.users.index')
                            ->with('success', 'User deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        $user_role = $user_edit = $user_delete = $user_create = $user_access = $user_show = 0;

        if ($this->user->can(['access-all', 'user-all'])) {
            $user_role = $user_edit = $user_delete = $user_create = $user_show = 1;
        }

        if ($this->user->can(['access-all'])) {
            $user_access = 1;
        }

        if ($this->user->can('user-delete')) {
            $user_delete = 1;
        }

        if ($this->user->can('user-show')) {
            $user_show = 1;
        }

        if ($this->user->can('user-edit')) {
            $user_edit = 1;
        }

        if ($this->user->can('user-create')) {
            $user_create = 1;
        }

        $data = User::orderBy('id', 'DESC')->get();
        $type_action = 'المستخدم';
        return view('admin.users.search', compact('type_action', 'data', 'user_access', 'user_create', 'user_role', 'user_show', 'user_edit', 'user_delete'));
    }

    public function postType(Request $request, $id, $name) {

        $data = Post::where('user_id', $id)->where('type', $name)->paginate($this->limit);

        $user = User::find($id);
        $name_array = ['posts'];

        $post_active = $post_create = $post_edit = $post_show = $post_delete = $post_list = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $post_active = $post_create = $post_edit = $post_show = $post_delete = $post_list = 1;
        }

        if ($this->user->can('post-edit')) {
            $post_active = $post_create = $post_edit = $post_show = $post_list = 1;
        }

        if ($this->user->id != $id) {

            if ($name == 'posts' && $post_active == 0 && $post_create == 0 && $post_edit == 0 && $post_show == 0 && $post_delete == 0 && $post_list = 0) {
                return $this->pageUnauthorized();
            }
            return view('admin.users.posttype', compact('data', 'name', 'post_active', 'post_create', 'post_edit', 'post_show', 'post_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            if (!empty($user) && in_array($name, $name_array)) {

                if ($this->user->can('post-create')) {
                    $post_create = 1;
                }

                if ($this->user->can('post-edit-only')) {
                    $post_edit = 1;
                }

                if ($this->user->can(['post-show', 'post-show-only'])) {
                    $post_show = 1;
                }

                if ($this->user->can(['post-delete', 'post-delete-only'])) {
                    $post_delete = 1;
                }

                if ($this->user->can(['post-list'])) {
                    $post_list = 1;
                }

                if ($name == 'posts' && $post_edit == 0 && $post_show == 0 && $post_delete == 0 && $post_create == 0 && $post_list = 0) {
                    return $this->pageUnauthorized();
                }
                $type_action = 'المستخدم';
                return view('admin.users.posttype', compact('type_action', 'data', 'name', 'post_active', 'post_create', 'post_edit', 'post_show', 'post_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return $this->pageError();
            }
        }
    }

    public function comments(Request $request, $id) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-list', 'comment-edit', 'comment-delete'])) {
            return $this->pageUnauthorized();
        }

        $comment_active = $comment_edit = $comment_delete = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all'])) {
            $comment_active = $comment_edit = $comment_create = $comment_delete = $comment_create = 1;
        }

        if ($this->user->can('comment-edit')) {
            $comment_active = $comment_edit = $comment_create = $comment_create = 1;
        }

        if ($this->user->can('comment-delete')) {
            $comment_delete = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }

        if ($this->user->id == $id) {
            if ($this->user->can('comment-edit-only')) {
                $comment_edit = 1;
            }

            if ($this->user->can('comment-delete-only')) {
                $comment_delete = 1;
            }
        }

        $data = Comment::where('user_id', $id)->paginate($this->limit);
        return view('admin.comments.index', compact('data', 'comment_create', 'comment_active', 'comment_create', 'comment_edit', 'comment_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

}
