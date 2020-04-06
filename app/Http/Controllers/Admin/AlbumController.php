<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Album;
use App\Model\Post;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class AlbumController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'category*'])) {
            return $this->pageUnauthorized();
        }
        
        $category_delete = $category_edit = $category_active = $category_show = $category_create = 0;
        
        if ($this->user->can(['access-all', 'post-type-all'])) {
            $category_delete = $category_active = $category_edit = $category_show = $category_create = 1;
        }
        
        if ($this->user->can('category-all')) {
            $category_delete = $category_active = $category_edit = $category_create = 1;
        } 
        
        if ($this->user->can('category-delete')) {
            $category_delete = 1;
        } 
        
        if ($this->user->can('category-edit')) {
            $category_active = $category_edit = $category_create = 1;
        }

        if ($this->user->can('category-create')) {
            $category_create = 1;
        }
        $type_action=' الالبوم';
        $data = Album::where('parent_id', null)->where('type', 'main')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.albums.index', compact('type_action','data', 'category_active','category_create',  'category_edit','category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['posts'];
        if (!in_array($type, $type_array)) {
            return $this->pageUnauthorized();
        }

        $category_delete = $category_edit = $category_active = $category_create = 0;
        
        if ($this->user->can(['access-all', 'post-type-all', 'category-all'])) {
            $category_delete = $category_active = $category_edit = $category_create = 1;
        } 
        
        if ($this->user->can('category-delete')) {
            $category_delete = 1;
        } 
        
        if ($this->user->can('category-edit')) {
            $category_active = $category_edit = $category_create = 1;
        }

        if ($this->user->can('category-create')) {
            $category_create = 1;
        }
        if($type=='sub'){
        $type_action=' فرعى';
        }else{
        $type_action=' الالبوم';
        }
        $data = Album::orderBy('id', 'DESC')->where('type', $type)->paginate($this->limit);
        return view('admin.albums.index', compact('type_action','data', 'category_create', 'category_edit', 'category_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-create', 'category-edit'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');
        if ($this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
            $category_active = 1;
        } else {
            $category_active = 0;
        }
        $categoryTags = [];
        $new = 1;
        $icon=$icon_image = '';
        $link_return=route('admin.albums.index'); 
        return view('admin.albums.create', compact('icon','icon_image','tags','link_return', 'new','category_active'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-create', 'category-edit'])) {
            if ($this->user->can('category-list')) {
                return redirect()->route('admin.albums.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => 'required|max:255',
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        
        $input['type'] = "main";
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        $input['is_active'] =1;
//        if (!isset($input['is_active'])) {
//            $category_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
//            $input['is_active'] = is_numeric($category_active) ? $category_active : 0;
//        }
        $input['user_id'] = $this->user->id;
        $album = Album::create($input);

        return redirect()->route('admin.albums.index')->with('success', 'Album created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request,$id) {
        $parent_id=$id;
        if (!$this->user->can(['access-all', 'post-type-all', 'category*'])) {
            return $this->pageUnauthorized();
        }
        
        $category_delete = $category_edit = $category_active = $category_show = $category_create = 0;
        
        if ($this->user->can(['access-all', 'post-type-all'])) {
            $category_delete = $category_active = $category_edit = $category_show = $category_create = 1;
        }
        
        if ($this->user->can('category-all')) {
            $category_delete = $category_active = $category_edit = $category_create = 1;
        } 
        
        if ($this->user->can('category-delete')) {
            $category_delete = 1;
        } 
        
        if ($this->user->can('category-edit')) {
            $category_active = $category_edit = $category_create = 1;
        }

        if ($this->user->can('category-create')) {
            $category_create = 1;
        }
        $type_action='البوم الصور';
        $data = Album::where('parent_id',$parent_id)->orderBy('id', 'DESC')->paginate($this->limit);
       
        return view('admin.subalbums.index', compact('type_action','data','parent_id', 'category_active','category_create',  'category_edit','category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        $album = Album::find($id);
        if (!empty($album)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.albums.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $category_active = 1;
            $new = 0;
            $link_return=route('admin.albums.index');
            $icon_image=$album->image;
            return view('admin.albums.edit', compact('icon_image','link_return','album','category_active','new'));
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

        $album = Album::find($id);
        if (!empty($album)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.albums.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            $this->validate($request, [
            'name' => 'required|max:255',
            'link' => "required|max:255",
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        $link_count = Album::foundLink($input['link']);
        if($link_count > 0){
          $input['link'] = $album->link;  
        }
        $album->update($input);

            return redirect()->route('admin.albums.index')
                            ->with('success', 'Album updated successfully');
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

        $album = Album::find($id);
        if (!empty($album)&& $id!=1) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.albums.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Album::find($id)->delete();
            Album::deleteParent($id);
            return redirect()->route('admin.albums.index')
                            ->with('success', 'Album deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-list'])) {
            return $this->pageUnauthorized();
        }

        $category_delete = $category_edit = $category_active = $category_show = $category_create = 0;
        
        if ($this->user->can(['access-all', 'post-type-all'])) {
            $category_delete = $category_active = $category_edit = $category_show = $category_create = 1;
        }
        
        if ($this->user->can('category-all')) {
            $category_delete = $category_active = $category_edit = $category_create = 1;
        } 
        
        if ($this->user->can('category-delete')) {
            $category_delete = 1;
        } 
        
        if ($this->user->can('category-edit')) {
            $category_active = $category_edit = $category_create = 1;
        }

        if ($this->user->can('category-create')) {
            $category_create = 1;
        }
        $type_action=' الالبوم';
//        $data = Album::with('user')->where('parent_id', 0)->where('type', 'main')->get();
        $data = Album::where('parent_id', 0)->where('type', 'main')->get();
        return view('admin.albums.search', compact('type_action','data','category_create', 'category_edit','category_show',  'category_active', 'category_delete'));
    }


}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








