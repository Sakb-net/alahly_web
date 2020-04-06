<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Tag;
use App\Model\Post;
use App\Model\Taggable;
use DB;

class TagController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all','post-type-all','post-all'])) {
            return $this->pageUnauthorized();
        }
        
        $tag_delete = $tag_edit = $tag_create = 0;
                
        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $tag_delete = $tag_edit = $tag_create = 1;
        }
        $type_action='tag';
        $data = Tag::orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.tags.index', compact('type_action','data', 'tag_edit', 'tag_delete', 'tag_create'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }
        $posts = Post::where('is_active', 1)->pluck('name', 'id');
        $tagPosts = [];
        $link_return=route('admin.tags.index');
        return view('admin.tags.create', compact('link_return','posts','tagPosts'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'name' => 'required|max:255|unique:tags,name',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "posts") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

//        $tag = new Tag();
//        $tag->insertTag($input['name']);
        $tag = Tag::create($input);
        $tag_id = $tag['id'];
        $posts = isset($input['posts']) ? $input['posts'] : array();
        if (!empty($posts)) {
            foreach ($posts as $posts_value) {
                $taggable = new Taggable();
                $taggable->insertTaggable($tag_id, stripslashes(trim(filter_var($posts_value, FILTER_SANITIZE_STRING))), "posts");
            }
        }

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request,$id) {
        $tag = Tag::find($id);
        if (!empty($tag)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
            }
            $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 1;
            }
            $data = Post::orderBy('id', 'DESC')->with('user')->where('type', 'posts')
                    ->Join('taggables as m2', function ($join) use ($id) {
                $join->on('posts.id','m2.taggable_id')
                ->where('m2.taggable_type', 'posts')
                ->where('m2.tag_id', $id);
            })->paginate($this->limit);
             $type_action='tag';
             $link_return=route('admin.tags.index');
            return view('admin.posts.index', compact('link_return','type_action','data','post_active','post_edit','post_create','post_show','post_delete','comment_list','comment_create'))->with('i', ($request->input('page', 1) - 1) * 5);
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

        $tag = Tag::find($id);
        if (!empty($tag)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            $posts = Post::where('is_active', 1)->pluck('name', 'id');
            $tagPosts = $tag->posts->pluck('id', 'id')->toArray();
            $link_return=route('admin.tags.index');
            return view('admin.tags.edit', compact('link_return','tag','posts', 'tagPosts'));
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

        $tag = Tag::find($id);
        if (!empty($tag)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return redirect()->route('admin.tags.index')->with('error', 'Have No Access');
            }

            $this->validate($request, [
                'name' => 'required|max:255|unique:tags,name,' . $id,
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "posts") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

//            $tag = new Tag();
//            $tag->updateTag($id, $input['name']);

            $tag->update($input);
            Taggable::deleteTagType($id, "posts");
            $posts = isset($input['posts']) ? $input['posts'] : array();
            if (!empty($posts)) {
                foreach ($posts as $posts_value) {
                    $taggable = new Taggable();
                    $taggable->insertTaggable($id, stripslashes(trim(filter_var($posts_value, FILTER_SANITIZE_STRING))), "posts");
                }
            }

            return redirect()->route('admin.tags.index')
                            ->with('success', 'Tag updated successfully');
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

        $tag = Tag::find($id);
        if (!empty($tag)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            Tag::find($id)->delete();
            return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $tag_delete = $tag_edit = $tag_create = 0;
        
        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $tag_delete = $tag_edit = $tag_create = 1;
        } 
        $type_action='tag';
        $data = Tag::all();
        return view('admin.tags.search', compact('type_action','data', 'tag_edit', 'tag_delete', 'tag_create'));
    }

}
