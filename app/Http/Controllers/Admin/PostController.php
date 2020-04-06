<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Post;
use App\Model\PostMeta;
use App\Model\CategoryPost;
use App\Model\Category;
use App\Model\Video;
use App\Model\Tag;
use App\Model\Taggable;
use App\Model\Comment;
use DB;

class PostController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-list', 'post-edit', 'post-delete', 'post-show'])) {
            return $this->pageUnauthorized();
        }

        $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-edit')) {
            $post_active = $post_edit = $post_create = $post_show = 1;
        }

        if ($this->user->can('post-delete')) {
            $post_delete = 1;
        }

        if ($this->user->can('post-show')) {
            $post_show = 1;
        }

        if ($this->user->can('post-create')) {
            $post_create = 1;
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
        $name = 'post';
        $type_action = 'Post';
        $type_name = '';
        $data = Post::with('categories')->orderBy('id', 'DESC')->where('type', 'post')->paginate($this->limit);
//        $data = Post::orderBy('id', 'DESC')->with('user')->where('type', 'post')->paginate($this->limit);
        return view('admin.posts.posts.index', compact('type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'post_active', 'post_create', 'post_edit', 'post_delete', 'post_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {
        if ($type == 'chair') {
            $type_name = 'المقاعد';
        } elseif ($type == 'service') {
            $type_name = 'الخدمات';
        } elseif ($type == 'branch') {
            $type_name = 'فروعنا';
        } elseif ($type == 'banner') {
            $type_name = 'بنر الاعلان';
        } elseif ($type == 'client') {
            $type_name = 'عملائنا';
        }

        $type_array = ['chair', 'service', 'branch', 'banner', 'client'];
        if (!in_array($type, $type_array)) {
            return $this->pageUnauthorized();
        }

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-list', 'post-edit', 'post-delete', 'post-show'])) {
            return $this->pageUnauthorized();
        }

        $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-edit')) {
            $post_active = $post_edit = $post_create = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-delete')) {
            $post_delete = 1;
        }

        if ($this->user->can('post-show')) {
            $post_show = 1;
        }

        if ($this->user->can('post-create')) {
            $post_create = 1;
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

        $name = $type;
        $type_action = $type_name;
        if ($type == 'chair') {
            $data = Category::whereHas('posts', function ($q)use($type) {
                        $q->where('type', '=', $type);
                    })->where('type', '=', 'section')->paginate($this->limit);
        } else {
            $data = Post::whereHas('categories', function ($q)use($type) {
                        $q->where('is_active', 1)->where('type', '=', $type);
                    })->paginate($this->limit);
        }
//                Post::orderBy('id', 'DESC')->with('user')->where('type', $type)->paginate($this->limit);
        return view('admin.posts.posts.indexSection', compact('type', 'type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'post_create', 'post_edit', 'post_active', 'post_delete', 'post_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function typeCategory(Request $request, $type, $cat_id) {
//        $ee=Post::get_LastChairRow('chair', $cat_id, 1, 'row');
//        print_r($ee);die;
        $category = Category::find($cat_id);
        if (isset($category->id)) {
            if ($type == 'chair') {
                $type_name = 'المقاعد';
            } elseif ($type == 'service') {
                $type_name = 'الخدمات';
            } elseif ($type == 'branch') {
                $type_name = 'فروعنا';
            } elseif ($type == 'banner') {
                $type_name = 'بنر الاعلان';
            } elseif ($type == 'client') {
                $type_name = 'عملائنا';
            }

            $type_array = ['chair', 'service', 'branch', 'banner', 'client'];
            if (!in_array($type, $type_array)) {
                return $this->pageUnauthorized();
            }

            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-list', 'post-edit', 'post-delete', 'post-show'])) {
                return $this->pageUnauthorized();
            }

            $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;

            if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 1;
            }

            if ($this->user->can('post-edit')) {
                $post_active = $post_edit = $post_create = $post_show = $comment_list = $comment_create = 1;
            }

            if ($this->user->can('post-delete')) {
                $post_delete = 1;
            }

            if ($this->user->can('post-show')) {
                $post_show = 1;
            }

            if ($this->user->can('post-create')) {
                $post_create = 1;
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

            $name = $type;
            $type_action = $type_name;

            $data = Post::whereHas('categories', function ($q)use($cat_id) {
                        $q->where('is_active', 1)->where('id', $cat_id)->where('type', '=', 'section');
                    })->paginate($this->limit);
            return view('admin.posts.posts.index', compact('cat_id', 'category', 'type', 'type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'post_create', 'post_edit', 'post_active', 'post_delete', 'post_show'))
                            ->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return $post->pageError();
        }
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create($type) {
        if ($type == 'chair') {
            $type_name = 'المقاعد';
        } elseif ($type == 'service') {
            $type_name = 'الخدمات';
        } elseif ($type == 'branch') {
            $type_name = 'فروعنا';
        } elseif ($type == 'banner') {
            $type_name = 'بنر الاعلان';
        } elseif ($type == 'client') {
            $type_name = 'عملائنا';
        }

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-create', 'post-edit'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');
        //category
        $categories = Category::cateorySelectArrayCol(0, 'section', 'type_state', ['normal', 'best', 'special'], 1, 0);
        $postTags = [];
        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
            $post_active = $image = 1;
        } else {
            $post_active = $image = 0;
        }
        if ($this->user->can(['image-upload', 'image-edit'])) {
            $image = 1;
        }
//        $row_valid = Post::get_categoryChairRow($input['type'], $category_id, $input['row'], 'row',-1);
        $new = 1;
        $image_link = $postCategories = NULL;
        $link_return = route('admin.posts.type', $type); //route('admin.posts.index');
        return view('admin.posts.posts.create', compact('type_name', 'type', 'link_return', 'tags', 'postTags', 'categories', 'postCategories', 'new', 'post_active', 'image', 'image_link'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-create', 'post-edit'])) {
            if ($this->user->can(['post-list'])) {
                return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        $this->validate($request, [
            'name' => 'required|max:255',
            'link' => "max:255|uniquePostLinkType:{$request->type}",
            'row' => 'required',
            'category_id' => 'required',
//            'categories' => 'required',
        ]);
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "category_id" && $key != "content" && $key != "tags" && $key != "videos" && $key != "brand_add" && $key != "categories") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
//        $input['type'] = "chair";
        $input['is_read'] = 1;
        $input['is_active'] = 1;
        if (!isset($input['num_chair']) || empty($input['num_chair']) || $input['num_chair'] <= 0) {
            $input['num_chair'] = 1;
        }
        if (!isset($input['row']) || empty($input['row'])) {
            $input['row'] = 0;
        }
        if (!isset($input['discount']) || empty($input['discount'])) {
            $input['discount'] = 0.00;
        }
        if (!isset($input['price']) || empty($input['price'])) {
            $input['price'] = 0.00;
        }
        if (!isset($input['is_comment'])) {
            $input['is_comment'] = $input['is_active'];
        }
//        $input['visitor'] = $request->ip();
        $input['user_id'] = $this->user->id;
        $input['update_by'] = $this->user->id;
        $category_id = (int) $input['category_id'];
        for ($i = 1; $i <= $input['num_chair']; $i++) {
            //if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . rand(100, 99999) . $i); //str_random(8)
//            }
            $row = Post::get_LastChairRow($input['type'], $category_id, $input['row'], 'row');
            if ($row <= 0) {
                return redirect()->route('admin.posts.type', $input['typePost'])->with('error', 'This Chair already exists');
            } else {
                $input['row'] = $row;
            }
            $post = Post::create($input);
            $post_id = $post['id'];
            $tags = isset($input['tags']) ? $input['tags'] : array();
            if (!empty($tags)) {
                foreach ($tags as $tags_value) {
                    $taggable = new Taggable();
                    if ($tags_value != NULL || $tags_value != '') {
                        $tag_found = new Tag();
                        $tag_id_found = $tag_found->foundTag($tags_value);
                        if ($tag_id_found > 0) {
                            $tag_id = $tag_id_found;
                        } else {
                            $tag_new = new Tag();
                            $tag_new->insertTag($tags_value);
                            $tag_id = $tag_new->id;
                        }
                        $taggable_id = Taggable::foundTaggable($tag_id, $post_id, "post");
                        if ($taggable_id == 0) {
                            $taggable->insertTaggable($tag_id, $post_id, "post");
                        }
                    }
                }
            }

//single category
            $post_category = new CategoryPost();
            if ($category_id > 0) {
                $post_category->insertCategoryPost($category_id, $post_id);
            }
        }
        return redirect()->route('admin.posts.type', $input['typePost'])->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show($id) {
//        $post = Post::find($id);
        return redirect()->route('admin.posts.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id, $type) {
        $post = Post::find($id);
        if ($type == 'chair') {
            $type_name = 'المقاعد';
        } elseif ($type == 'service') {
            $type_name = 'الخدمات';
        } elseif ($type == 'branch') {
            $type_name = 'فروعنا';
        } elseif ($type == 'banner') {
            $type_name = 'بنر الاعلان';
        } elseif ($type == 'client') {
            $type_name = 'عملائنا';
        }

        if (!empty($post)) {
            if ($this->user->id != $post->user_id) {
                if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit', 'post-edit-only'])) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }
            if ($this->user->can('post-edit-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }
            $image = $new = 0;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                $post_active = $image = 1;
            } else {
                $post_active = 0;
            }
            if ($this->user->can(['image-edit'])) {
                $image = 1;
            }
            $image_link = $post->image;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                $post_active = 1;
            } else {
                $post_active = 0;
            }
            if ($post_active == 1) {
                $post->updateColum($id, 'is_read', 1);
            }
            //category
            $postCategories = $post->categories[0]->id; //pluck('id', 'id'); //->toArray();
            $categories = Category::cateorySelectArrayCol(0, 'section', 'type_state', ['normal', 'best', 'special'], 1, 0);

            $tags = Tag::pluck('name', 'name');
//            $postTags = $post->tags->pluck('name', 'name')->toArray();
            $postTags = Tag::whereIn('id', function($query)use ($id) {
                        $query->select('tag_id')
                                ->from(with(new Taggable)->getTable())
                                ->where('is_search', 1)->where('taggable_id', '=', $id)->where('taggable_type', '=', 'post');
                    })->pluck('name', 'name')->toArray();

//            $row = Post::get_categoryChairRow($input['type'], $category_id, $input['row'], 'row', -1);
            if ($post->type == 'chair') {
                $link_return = route('admin.posts.type.category', [$post->type, $postCategories]);
            } else {
                $link_return = route('admin.posts.type', $post->type); //route('admin.posts.index');
            }
            return view('admin.posts.posts.edit', compact('type', 'type_name', 'link_return', 'post', 'postTags', 'postCategories', 'tags', 'categories', 'new', 'image', 'image_link', 'post_active'));
        } else {
            return $post->pageError();
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
        $post = Post::find($id);
        $image = 0;
        if (!empty($post)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit', 'post-edit-only'])) {
                if ($this->user->can(['post-list', 'post-create'])) {
                    return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                } else {
                    return $post->pageUnauthorized();
                }
            }

            if ($this->user->can('post-edit-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }
            if ($request->type == 'banner') {
                $this->validate($request, [
                    'link' => "max:255|uniquePostUpdateLinkType:$request->type,$id",
                    'category_id' => 'required',
//            'categories' => 'required',
                ]);
            } else {
                $this->validate($request, [
                    'name' => 'required|max:255',
                    'link' => "max:255|uniquePostUpdateLinkType:$request->type,$id",
                    'category_id' => 'required',
                    'row' => 'required',
                ]);
            }
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "category_id" && $key != "content" && $key != "tags" && $key != "categories" && $key != "brand" && $key != "brand_add" && $key != "videos") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
//            $input['type'] = "post";
//        if (!isset($input['is_active'])) {
//            $post_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
//            $input['is_active'] = is_numeric($post_active) ? $post_active : 0;
//        }
            $input['update_by'] = $this->user->id;
            $category_id = (int) $input['category_id'];
            if ($post->row != $input['row']) {
                $row = Post::check_LastChairRow($input['type'], $category_id, $input['row'], 'row');
                if ($row == 0) {
                    $input['row'] = $post->row;
                }
            }
            $post->update($input);
            $post_id = $post->id;

            Taggable::deleteTaggableType($id, $input['type']);
            $tags = isset($input['tags']) ? $input['tags'] : array();
            if (!empty($tags)) {
                foreach ($tags as $tags_value) {
                    $taggable = new Taggable();
                    if ($tags_value != NULL || $tags_value != '') {
                        $tag_found = new Tag();
                        $tag_id_found = $tag_found->foundTag($tags_value);
                        if ($tag_id_found > 0) {
                            $tag_id = $tag_id_found;
                        } else {
                            $tag_new = new Tag();
                            $tag_new->insertTag($tags_value);
                            $tag_id = $tag_new->id;
                        }
                        $taggable_id = Taggable::foundTaggable($tag_id, $post->id, "post");
                        if ($taggable_id == 0) {
                            $taggable->insertTaggable($tag_id, $post->id, "post");
                        }
                    }
                }
            }
//single category
            CategoryPost::deletePost($id);
            $post_category = new CategoryPost();
            if ($category_id > 0) {
                $post_category->insertCategoryPost($category_id, $id);
            }

            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                if ($post->type == 'chair') {
                    return redirect()->route('admin.posts.type.category', [$input['typePost'], $category_id])
                                    ->with('success', 'Updated successfully');
                } else {
                    return redirect()->route('admin.posts.type', $input['typePost'])
                                    ->with('success', 'Updated successfully');
                }
            } elseif ($this->user->can('post-edit-only')) {
                return redirect()->route('admin.users.posttype', [$this->user->id, 'post'])->with('success', 'Updated successfully');
            }
        } else {
            return $post->pageError();
        }
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function deletetypeCategory($type, $cat_id) {
        $category = Category::find($cat_id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-delete', 'post-delete-only'])) {
                if ($this->user->can(['post-list'])) {
                    return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                } else {
                    return $category->pageUnauthorized();
                }
            }

            if ($this->user->can('post-delete-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-delete'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $category->pageUnauthorized();
                    }
                }
            }
            $typeCat = 'chair';
            $data = Post::whereHas('categories', function ($q)use($cat_id) {
                        $q->where('is_active', 1)->where('id', $cat_id)->where('type', '=', 'section');
                    })->get();
            foreach ($data as $key => $val_post) {
                Taggable::deleteTaggableType($val_post->id, $val_post->type);
                Post::find($val_post->id)->delete();
            }
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-delete'])) {
                return redirect()->route('admin.posts.type', $typeCat)
                                ->with('success', 'Deleted successfully');
            } elseif ($this->user->can(['post-delete-only'])) {
                return redirect()->route('admin.users.posttype', [$this->user->id, 'posts'])->with('success', 'Post deleted successfully');
            }
        } else {
            return $post->pageError();
        }
    }

    public function destroy($id) {
        $post = Post::find($id);
        if (!empty($post)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-delete', 'post-delete-only'])) {
                if ($this->user->can(['post-list'])) {
                    return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                } else {
                    return $post->pageUnauthorized();
                }
            }

            if ($this->user->can('post-delete-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-delete'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }
            $typeCat = $post->type;//$post->categories[0]['type'];
            Taggable::deleteTaggableType($id, $post->type);
            Post::find($id)->delete();
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-delete'])) {
                return redirect()->route('admin.posts.type', $typeCat)
                                ->with('success', 'Post deleted successfully');
            } elseif ($this->user->can(['post-delete-only'])) {
                return redirect()->route('admin.users.posttype', [$this->user->id, 'posts'])->with('success', 'Post deleted successfully');
            }
        } else {
            return $post->pageError();
        }
    }

    public function search($type) {
        if ($type == 'chair') {
            $type_name = 'المقاعد';
        } elseif ($type == 'service') {
            $type_name = 'الخدمات';
        } elseif ($type == 'branch') {
            $type_name = 'فروعنا';
        } elseif ($type == 'banner') {
            $type_name = 'بنر الاعلان';
        } elseif ($type == 'client') {
            $type_name = 'عملائنا';
        }

        $type_action = $type_name;
        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-list', 'post-edit', 'post-delete', 'post-show'])) {
            return $post->pageUnauthorized();
        }

        $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-edit')) {
            $post_active = $post_edit = $post_create = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-delete')) {
            $post_delete = 1;
        }

        if ($this->user->can('post-show')) {
            $post_show = 1;
        }

        if ($this->user->can('post-create')) {
            $post_create = 1;
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
        $name = 'posts';
        $data = Post::whereHas('categories', function ($q)use($type) {
                    $q->where('is_active', 1)->where('type', '=', 'section');
                })->get();
        return view('admin.posts.posts.search', compact('type', 'type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'post_active', 'post_create', 'post_edit', 'post_delete', 'post_show'));
    }

    //***************************************** comment *************************************************
    public function comments(Request $request, $id) {

        $post = Post::find($id);
        if (!empty($post)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit', 'post-edit-only', 'post-show', 'post-show-only'])) {
                if ($this->user->can(['post-list', 'post-create'])) {
                    return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                } else {
                    return $post->pageUnauthorized();
                }
            }

            if ($this->user->can(['post-edit-only', 'post-show-only']) && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit', 'post-show'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }

            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-list', 'comment-edit', 'comment-delete'])) {
                return $post->pageUnauthorized();
            }

            $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 0;

            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all'])) {
                $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-edit', 'comment-edit-post-only'])) {
                $comment_active = $comment_edit = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-delete', 'comment-delete-post-only'])) {
                $comment_delete = 1;
            }

            if ($this->user->can('comment-create')) {
                $comment_create = 1;
            }

            $name = 'posts';

            $data = Comment::where('commentable_id', $id)->where('commentable_type', 'posts')->paginate($this->limit);
            return view('admin.posts.posts.comments', compact('data', 'id', 'name', 'comment_create', 'comment_list', 'comment_active', 'comment_edit', 'comment_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return $post->pageError();
        }
    }

    public function commentCreate($id) {

        $post = Post::find($id);
        if (!empty($post)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                return $post->pageUnauthorized();
            }
            $users = User::pluck('id', 'name');
            $comment_active = $user_active = 0;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $new = 1;
            $user_id = $this->user->id;
            return view('admin.posts.posts.comment_create', compact('users', 'user_id', 'id', 'new', 'comment_active'));
        } else {
            return $post->pageError();
        }
    }

    public function commentStore(Request $request, $id) {

        $post = Post::find($id);
        if (!empty($post)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                if ($this->user->can(['post-list'])) {
                    return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                } else {
                    return $post->pageUnauthorized();
                }
            }
            $post->validate($request, [
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $input['type'] = "posts";
            $is_read = 1;

            if (!isset($input['is_active'])) {
                $comment_active = DB::table('options')->where('option_key', 'comment_active')->value('option_value');
                $input['is_active'] = is_numeric($comment_active) ? $comment_active : 0;
                $input['user_id'] = $this->user->id;
                $is_read = 0;
            }
            $name = User::userData($input['user_id'], "name");
            $email = User::userData($input['user_id'], "email");
            $visitor = $request->ip();
            $comment = new Comment();
            $comment->insertComment($input['user_id'], $visitor, $name, $email, $id, $input['type'], $input['content'], 0, "text", $is_read, $input['is_active']);
            return redirect()->route('admin.posts.comments.index', [$id])->with('success', 'Comment created successfully');
        } else {
            return $post->pageError();
        }
    }

}
