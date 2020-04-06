<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Blog;
use App\Model\CommentBlog;
use App\Model\Language;

//use URL;
class BlogController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'blog-list', 'blog-edit', 'blog-delete', 'blog-show'])) {
            return $this->pageUnauthorized();
        }

        $blog_active = $blog_edit = $blog_create = $blog_delete = $blog_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'blog-type-all', 'blog-all'])) {
            $blog_active = $blog_edit = $blog_create = $blog_delete = $blog_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('blog-edit')) {
            $blog_active = $blog_edit = $blog_create = $blog_show = 1;
        }

        if ($this->user->can('blog-delete')) {
            $blog_delete = 1;
        }

        if ($this->user->can('blog-show')) {
            $blog_show = 1;
        }

        if ($this->user->can('blog-create')) {
            $blog_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        if ($this->user->lang == 'ar') {
            $type_action = "الأخبار";
        } else {
            $type_action = "Blog";
        }
        $name = $type = 'blog';
        $data = Blog::getBlogs('lang', 'ar', $type, NULL, '=', $this->limit);
        //language 
        $mainLanguage = Language::get_Languag('is_active', 1, 'lang', 1);
        return view('admin.blogs.index', compact('mainLanguage', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'blog_active', 'blog_create', 'blog_edit', 'blog_delete', 'blog_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function languages(Request $request, $id) {

        if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'blog-list', 'blog-edit', 'blog-delete', 'blog-show'])) {
            return $blog->pageUnauthorized();
        }

        $blog_active = $blog_edit = $blog_create = $blog_delete = $blog_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'blog-type-all', 'blog-all'])) {
            $blog_active = $blog_edit = $blog_create = $blog_delete = $blog_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('blog-edit')) {
            $blog_active = $blog_edit = $blog_create = $blog_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('blog-delete')) {
            $blog_delete = 1;
        }

        if ($this->user->can('blog-show')) {
            $blog_show = 1;
        }

        if ($this->user->can('blog-create')) {
            $blog_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        if ($this->user->lang == 'ar') {
            $type_action = "الأخبار ";
        } else {
            $type_action = "Blog";
        }
        $name = $type_action;
        $type = 'blog';
        $data = Blog::getBlogs('lang_id', $id, $type, NULL, '=', 0);
        //language 
        $mainLanguage = Language::get_Languag('is_active', 1, 'lang', 1);  //'mainLanguage',
        return view('admin.blogs.indexlang', compact('mainLanguage', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'blog_active', 'blog_create', 'blog_edit', 'blog_delete', 'blog_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function BlogArrange(Request $request) {
        if (!$this->user->can(['access-all', 'blog*'])) {
            return $this->pageUnauthorized();
        }
        $blog_delete = $blog_edit = $blog_active = $blog_show = $blog_create = 0;
        if ($this->user->can(['access-all', 'blog-type-all'])) {
            $blog_delete = $blog_active = $blog_edit = $blog_show = $blog_create = 1;
        }
        if ($this->user->can('blog-all')) {
            $blog_delete = $blog_active = $blog_edit = $blog_create = 1;
        }
        if ($this->user->can('blog-delete')) {
            $blog_delete = 1;
        }
        if ($this->user->can('blog-edit')) {
            $blog_active = $blog_edit = $blog_create = 1;
        }
        if ($this->user->can('blog-create')) {
            $blog_create = 1;
        }
        if ($this->user->lang == 'ar') {
            $type_action = "الأخبار";
        } else {
            $type_action = "Blog";
        }
        $type = $name = 'blog';
        $id = 0;
        $blog = [];
        $data = Blog::getBlogs('lang', 'ar', $type, NULL, '=', 0);
        $link_return = route('admin.blogs.index');
        return view('admin.blogs.editArrangeBlog', compact('link_return', 'blog', 'id', 'type_action', 'data', 'blog_active', 'blog_create', 'blog_edit', 'blog_show', 'blog_delete'));
    }

    public function storeBlogArrange(Request $request) {

        if (!$this->user->can(['access-all', 'blog-all', 'blog-create', 'blog-edit'])) {
            if ($this->user->can('blog-list')) {
                session()->put('error', trans('app.no_access'));
                return redirect()->route('admin.blogs.index');
            } else {
                return $this->pageUnauthorized();
            }
        }
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "newArray_order_id") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $arrayCategory = isset($_POST['newArray_order_id']) ? $_POST['newArray_order_id'] : array();
        if (!empty($arrayCategory)) {
            foreach ($arrayCategory as $key_order => $blog_value) {
                $input['order_id'] = $key_order + 1;
                $id = (int) $blog_value;  //blog_id
                if ($id != '' && $id != 0) {
                    //change order row with same row by another lang
                    Blog::updateOrderColum('lang_id', $id, 'order_id', $input['order_id']);
//                    $blog = Blog::find($id);
//                    $update_blog = $blog->update($input);
                }
            }
        }
        session()->put('success', trans('app.update_success'));
        return redirect()->route('admin.blogs.index');
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'blog-all', 'blog-create', 'blog-edit'])) {
            return $this->pageUnauthorized();
        }
        if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
            $blog_active = 1;
        } else {
            $blog_active = 0;
        }
        $blogTags = [];
        $tags = []; //Tag::pluck('name', 'name');
        $link_return = route('admin.blogs.index');
        $new = $image = 1;
        $image_link = NULL;
        $lang = 'ar';
        $lang_id = $blog_ar_name = '';
        return view('admin.blogs.create', compact('blog_ar_name', 'lang_id', 'lang', 'image_link', 'image', 'link_return', 'tags', 'new', 'blog_active', 'blogTags'));
    }

    public function createLang($id, $lang) {

        if (!$this->user->can(['access-all', 'blog-all', 'blog-create', 'blog-edit'])) {
            return $this->pageUnauthorized();
        }
        if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
            $blog_active = 1;
        } else {
            $blog_active = 0;
        }
        $blogTags = [];
        $tags = []; // Tag::pluck('name', 'name');

        $link_return = route('admin.blogs.index');
        $new = $image = 1;
        $image_link = NULL;
        $lang_id = $id;
        $blog_ar_name = '';
        $blog_ar = Blog::find($id);
        if (isset($blog_ar->name)) {
            $blog_ar_name = $blog_ar->name;
            $image_link = $blog_ar->image;
            $color = $blog_ar->color;
        }
        return view('admin.blogs.create', compact('color', 'blog_ar_name', 'lang_id', 'lang', 'image_link', 'image', 'link_return', 'tags', 'new', 'blog_active', 'blogTags'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {
        if (!$this->user->can(['access-all', 'blog-all', 'blog-create', 'blog-edit'])) {
            if ($this->user->can('blog-list')) {
                session()->put('error', trans('app.no_access'));
                return redirect()->route('admin.blogs.index');
            } else {
                return $this->pageUnauthorized();
            }
        }
        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniqueCategoryLinkType:{$request->type}",
//            'category_id' => "required|ValueSelectID:{$request->category_id}",
//            'instructor_id' => "required|ValueSelectID:{$request->instructor_id}",
        ]);
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags" && $key != "content" && $key != "description") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $order_id = Blog::get_LastRow($input['lang'], 'order_id');
        $input['order_id'] = $order_id + 1;
        $input['type'] = "blog";
        $input['user_id'] = $this->user->id;
        $input['update_by'] = $this->user->id;
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        if ($input['lang_id'] == '') {
            $input['lang_id'] = Null;
        }
        $input['is_active'] = 1;
        $tags = isset($input['tags']) ? $input['tags'] : array();
        $input['tags'] = json_encode($tags);
        $blog = Blog::create($input);
        $blog_id = $taggable_id = $blog['id'];
        if ($input['lang'] == 'ar') {
            Blog::updateColum($blog_id, 'lang_id', $blog_id);
        }
        session()->put('success', trans('app.save_success'));
        return redirect()->route('admin.blogs.index');
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
//        $blog = Blog::find($id);
        return redirect()->route('admin.blogs.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $blog = Blog::find($id);
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-all', 'blog-edit', 'blog-edit-only'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }

            if ($this->user->can('blog-edit-only') && !$this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }

            $image = $new = 0;
            if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                $blog_active = $image = 1;
            } else {
                $blog_active = 0;
            }
            if ($this->user->can(['image-edit'])) {
                $image = 1;
            }
            $image_link = $blog->image;
            if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                $blog_active = 1;
            } else {
                $blog_active = 0;
            }
//            $tags =Tag::pluck('name', 'name');
            $blogTags = [];
            $array_Tags = json_decode($blog->tags);
            foreach ($array_Tags as $key => $val_tage) {
                $blogTags[$val_tage] = $val_tage;
            }
            $tags = $blogTags;
            $lang = 'ar';
            $lang_id = $blog_ar_name = '';
            $link_return = route('admin.blogs.index');
            return view('admin.blogs.edit', compact('lang_id', 'blog_ar_name', 'lang', 'link_return', 'blog', 'blogTags', 'tags', 'new', 'image', 'image_link', 'blog_active'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function editLang($id, $lang) {
        $blog = Blog::find($id);
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-all', 'blog-edit', 'blog-edit-only'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }

            if ($this->user->can('blog-edit-only') && !$this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }

            $image = $new = 0;
            if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                $blog_active = $image = 1;
            } else {
                $blog_active = 0;
            }
            if ($this->user->can(['image-edit'])) {
                $image = 1;
            }
            $image_link = $blog->image;
            if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                $blog_active = 1;
            } else {
                $blog_active = 0;
            }
//            $tags =Tag::pluck('name', 'name');
            $blogTags = [];
            $array_Tags = json_decode($blog->tags);
            foreach ($array_Tags as $key => $val_tage) {
                $blogTags[$val_tage] = $val_tage;
            }
            $tags = $blogTags;
            $lang_id = '';
            $blog_ar_name = '';
            $blog_ar = Blog::find($blog->lang_id);
            if (isset($blog_ar->name)) {
                $lang_id = $blog_ar->id;
                $blog_ar_name = $blog_ar->name;
            }

            $link_return = route('admin.blogs.index');
            return view('admin.blogs.edit', compact('lang_id', 'blog_ar_name', 'lang', 'link_return', 'blog', 'blogTags', 'tags', 'new', 'image', 'image_link', 'blog_active'));
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
        $blog = Blog::find($id);
        $image = 0;
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-all', 'blog-edit', 'blog-edit-only'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }

            if ($this->user->can('blog-edit-only') && !$this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'name' => 'required|max:255',
//                'link' => "max:255|uniquePostUpdateLinkType:$request->type,$id",
//                'instructor_id' => "required|ValueSelectID:{$request->instructor_id}",
//                'category_id' => "required|ValueSelectID:{$request->category_id}",
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags" && $key != "content" && $key != "description") { //$key != "content" &&
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
            $input['type'] = "blog";
//            $input['user_id'] = $input['instructor_id'];
            $input['lang'] = $blog->lang;
            $input['lang_id'] = $blog->lang_id;
            $input['update_by'] = $this->user->id;
            $input['link'] = str_replace(' ', '_', $input['link']);
            $tags = isset($input['tags']) ? $input['tags'] : array();
            $input['tags'] = json_encode($tags);
            $blog->update($input);
            session()->put('success', trans('app.save_success'));
            if ($this->user->can(['access-all', 'blog-all', 'blog-edit'])) {
                return redirect()->route('admin.blogs.index');
            } elseif ($this->user->can('blog-edit-only')) {
                return redirect()->route('admin.users.blogtype', [$this->user->id, 'course']);
            }
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

        $blog = Blog::find($id);
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-all', 'blog-delete'])) {
                if ($this->user->can(['blog-list', 'blog-edit'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.blogs.index');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Blog::find($id)->delete();
//            Taggable::deleteTaggableType($id, "blog");
            return redirect()->route('admin.blogs.index')
                            ->with('success', 'Deleted successfully');
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'blog-list', 'blog-edit', 'blog-delete', 'blog-show'])) {
            return $blog->pageUnauthorized();
        }

        $blog_active = $blog_edit = $blog_create = $blog_delete = $blog_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'blog-type-all', 'blog-all'])) {
            $blog_active = $blog_edit = $blog_create = $blog_delete = $blog_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('blog-edit')) {
            $blog_active = $blog_edit = $blog_create = $blog_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('blog-delete')) {
            $blog_delete = 1;
        }

        if ($this->user->can('blog-show')) {
            $blog_show = 1;
        }

        if ($this->user->can('blog-create')) {
            $blog_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        if ($this->user->lang == 'ar') {
            $type_action = "الأخبار ";
        } else {
            $type_action = "Blog";
        }
        $name = 'blogs';
//        $data = Blog::with('user')->where('type', 'blog')->get(); , 'data'
        return view('admin.blogs.search', compact('type_action', 'name', 'comment_create', 'comment_list', 'blog_active', 'blog_create', 'blog_edit', 'blog_delete', 'blog_show'));
    }

///*****************  comment for blog ***********************************
    public function comments(Request $request, $id) {
        $blog = Blog::find($id);
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'blog-edit', 'blog-edit-only', 'blog-show', 'blog-show-only'])) {
                if ($this->user->can(['blog-list', 'blog-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.' . $blog->type . 's.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }
            if ($this->user->can(['blog-edit-only', 'blog-show-only']) && !$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'blog-edit', 'blog-show'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['blog-list', 'blog-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.' . $blog->type . 's.index');
                    } else {
                        return $blog->pageUnauthorized();
                    }
                }
            }

            if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'comment-all', 'comment-list', 'comment-edit', 'comment-delete'])) {
                return $blog->pageUnauthorized();
            }

            $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 0;

            if ($this->user->can(['access-all', 'blog-type-all', 'blog-all', 'comment-all'])) {
                $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-edit', 'comment-edit-blog-only'])) {
                $comment_active = $comment_edit = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-delete', 'comment-delete-blog-only'])) {
                $comment_delete = 1;
            }

            if ($this->user->can('comment-create')) {
                $comment_create = 1;
            }

            $name = $blog->type;
            $type_action = '';
            $data = CommentBlog::where('blog_id', $id)->paginate($this->limit);  //where('type','question')->
            $link_return = route('admin.blogs.index'); //route('admin.blogs.comments.index',$id);
            return view('admin.blogcomments.index', compact('link_return','blog', 'type_action', 'data', 'id', 'name', 'comment_create', 'comment_list', 'comment_active', 'comment_edit', 'comment_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function commentCreate($id) {

        $blog = Blog::find($id);
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                return $blog->pageUnauthorized();
            }
            $users = User::pluck('id', 'name');
            $comment_active = $user_active = 0;
            if ($this->user->can(['access-all', 'blog-type-all', 'blog-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $new = 1;
            $user_id = $this->user->id;
            $link_return = route('admin.blogs.comments.index',$blog->id);
            return view('admin.blogcomments.create', compact('users','blog','link_return','user_id', 'id', 'new', 'comment_active'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function commentStore(Request $request, $id) {
        $blog = Blog::find($id);
        if (!empty($blog)) {
            if (!$this->user->can(['access-all', 'blog-type-all', 'blog-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                if ($this->user->can(['blog-list'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.' . $blog->type . 's.index');
                } else {
                    return $blog->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $input['type'] = $blog->type;
            $is_read = 1;
            if (!isset($input['is_active'])) {
                $comment_active = \App\Model\Options::where('option_key', 'comment_active')->value('option_value');
                $input['is_active'] = is_numeric($comment_active) ? $comment_active : 0;
                $input['user_id'] = $this->user->id;
                $is_read = 0;
            }
            $name = $this->user->display_name;
            $email = $this->user->email;
            $user_image = $this->user->image;
            if(empty($user_image)){
                $user_image = '/images/user.png';
            }
            $visitor = $request->ip();
            $comment = new CommentBlog();
            $comment->insertComment($input['user_id'], $user_image, $name, $email, $id, $input['type'], $input['content'], null, "text", $is_read, $input['is_active']);
            session()->put('success', trans('app.save_success'));
            return redirect()->route('admin.' . $blog->type . 's.comments.index', [$id]);
//            return redirect()->route('admin.lectures.comments.index', [$id]);
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

}
