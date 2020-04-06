<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Album;
use App\Model\Post;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class SubalbumController extends AdminController {

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
        $type_action = 'صور ';
        $data = Album::where('parent_id', '<>', 0)->where('type', 'sub')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.subalbums.index', compact('type_action', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
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
        if ($this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
            $category_active = 1;
        } else {
            $category_active = 0;
        }
        $album_all = Album::where('type', 'main')->where('parent_id', null)->where('is_active', 1)->pluck('id', 'name')->toArray();
        $first_title = ['اختر  الالبوم' => 0];
        $albums = array_flip(array_merge($first_title, $album_all));
        $new = 1;
        $icon_image = '';
        $parent_id = null;
        $link_return = route('admin.subalbums.index');
        return view('admin.subalbums.create', compact('albums', 'parent_id', 'link_return', 'icon_image', 'new', 'category_active'));
    }

    public function create_subalbum($id) {
        $parent_id = $id;
        if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-create', 'category-edit'])) {
            return $this->pageUnauthorized();
        }
        if ($this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
            $category_active = 1;
        } else {
            $category_active = 0;
        }
        $album_all = Album::where('type', 'main')->where('parent_id', null)->where('is_active', 1)->pluck('id', 'name')->toArray();
        $first_title = ['اختر  الالبوم' => 0];
        $albums = array_flip(array_merge($first_title, $album_all));
        $new = 1;
        $icon_image = '';
        $link_return = route('admin.albums.show', $parent_id);
        return view('admin.subalbums.create', compact('albums', 'parent_id', 'link_return', 'icon_image', 'new', 'category_active'));
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
                return redirect()->route('admin.subalbums.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        if ($request->parent_id == 0 || empty($request->parent_id)) {
            $request->parent_id = null;
        }
//        print_r($request->parent_id);die;
        $this->validate($request, [
            'name' => 'required|max:255',
            'parent_id' => 'required',
//            'link' => 'required|max:255',
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $parent_id = $input['parent_id'];
        if ($parent_id != 0 && !empty($parent_id)) {
            $input['type'] = "sub";
            if ($input['link'] == Null) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $input['is_active'] = 1;
            $input['user_id'] = $this->user->id;
            $album = Album::create($input);
//            $album_id = $album['id']
//            if ($input['lang'] == 'ar') {
//                Album::updateColum($album_id, 'lang_id', $album_id);
//            }
//            $taggable_id = $album_id;
        } else {
            return redirect()->route('admin.subalbums.create')->with('error', 'اختر  الالبوم');
        }
//        return redirect()->route('admin.subalbums.index')->with('success', 'Created successfully');
        return redirect()->route('admin.albums.show', $parent_id)->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
//        $category = Album::find($id);
        return redirect()->route('admin.subalbums.edit', $id);
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
                    return redirect()->route('admin.subalbums.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $category_active = 1;
            $album_all = Album::where('type', 'main')->where('parent_id', null)->where('is_active', 1)->where('id', '<>', $id)->pluck('id', 'name')->toArray();
            $first_title = ['اختر  الالبوم' => 0];
            $albums = array_flip(array_merge($first_title, $album_all));
            $new = 0;
            $icon_image = $album->image;
            $parent_id = $album->parent_id;
            $link_return = $link_return = route('admin.albums.show', $parent_id); //route('admin.subalbums.index');
            return view('admin.subalbums.edit', compact('icon_image', 'parent_id', 'link_return', 'album', 'albums', 'category_active', 'new'));
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
                    return redirect()->route('admin.subalbums.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            if ($request->parent_id == 0 || empty($request->parent_id)) {
                $request->parent_id = null;
            }
            $this->validate($request, [
                'name' => 'required|max:255',
                'parent_id' => 'required',
                'link' => "required|max:255",
            ]);


            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
            $parent_id = $input['parent_id'];
            if ($parent_id != 0 && !empty($parent_id)) {
                $link_count = Album::foundLink($input['link']);
                if ($link_count > 0) {
                    $input['link'] = $album->link;
                }
                $album->update($input);
            } else {
                return redirect()->route('admin.subalbums.update', $album->parent_id)->with('error', 'اختر  الالبوم');
            }
//            return redirect()->route('admin.subalbums.index')->with('success', 'Updated  successfully');
            return redirect()->route('admin.albums.show', $parent_id)->with('success', 'Updated  successfully');
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
        if (!empty($album)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.subalbums.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Album::find($id)->delete();
            return redirect()->route('admin.subalbums.index')
                            ->with('success', 'Deleted successfully');
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
        $type_action = 'صور ';
//        $data = Album::with('user')->where('parent_id','<>', 0)->where('type', 'sub')->get();
        $data = Album::where('parent_id', '<>', 0)->where('type', 'sub')->get();
        return view('admin.subalbums.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








