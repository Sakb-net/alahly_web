<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Category;
use App\User;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class AudienceController extends AdminController {

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
        $type_action = 'مجلس الجمهور';
        $data = Category::where('type', 'audience')->where('parent_id', 0)->orderBy('id', 'DESC')->paginate($this->limit); //where('parent_id','<>', 0)->
        return view('admin.audiences.index', compact('type_action', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['audience'];
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
        $type_action = 'مجلس الجمهور';
        $data = Category::where('type', 'audience')->orderBy('id', 'DESC')->where('parent_id', 0)->paginate($this->limit);  //where('type','<>', 'banner')->
        return view('admin.audiences.index', compact('type_action', 'data', 'category_create', 'category_edit', 'category_delete'))
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
        $lang = 'ar';
        $categoryTags = $all_itemvote = [];
        $new = 1;
        $icon = $icon_image = '';
        $link_return = route('admin.audiences.index');
        return view('admin.audiences.create', compact('icon', 'lang', 'all_itemvote', 'icon_image', 'tags', 'link_return', 'new', 'category_active', 'categoryTags'));
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
                return redirect()->route('admin.audiences.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniqueCategoryLinkType:{$request->type}",
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags" && $key != "itemvote_add") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $input['type'] = "audience"; //"main";
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
//        if (!isset($input['is_active'])) {
//            $category_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
//            $input['is_active'] = is_numeric($category_active) ? $category_active : 0;
//        }
        $input['is_active'] = 1;
        $input['user_id'] = $this->user->id;
        $category = Category::create($input);
        $category_id = $category['id'];
        if ($input['lang'] == 'ar') {
            Category::updateColum($category_id, 'lang_id', $category_id);
        }
        $itemvote_add = isset($input['itemvote_add']) ? $input['itemvote_add'] : array();
        if (!empty($itemvote_add)) {
            foreach ($itemvote_add as $itemvote_add_value) {
                $input['name'] = trim(filter_var($itemvote_add_value['answer'], FILTER_SANITIZE_STRING));
                $input['link'] = str_replace(' ', '_', time() . str_random(8));
                $input['parent_id'] = $category_id;
                $input['lang'] = 'ar';
                if (!empty($input['name'])) {
                    $category_ans = Category::create($input);
                    $category_ans_id = $category_ans['id'];
                    if ($input['lang'] == 'ar') {
                        Category::updateColum($category_ans_id, 'lang_id', $category_ans_id);
                    }
                }
            }
        }
        $taggable_id = $category_id;
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
                    $taggable->insertTaggable($tag_id, $taggable_id, "audience");
                }
            }
        }
        return redirect()->route('admin.audiences.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
        return redirect()->route('admin.audiences.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $category = Category::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.audiences.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $lang = 'ar';
            $tags = Tag::pluck('name', 'name');
            $category_active = 1;
            $categoryTags = $category->tags->pluck('name', 'name')->toArray();
            $all_itemvote = $category->childrens;
            $new = 0;
            $link_return = route('admin.audiences.index');
            $icon_image = $category->icon_image;
            $icon = $category->icon;
            return view('admin.audiences.edit', compact('icon', 'all_itemvote', 'lang', 'icon_image', 'link_return', 'category', 'category_active', 'tags', 'categoryTags', 'new'));
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
        $category = Category::where('type', 'audience')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.audiences.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'name' => 'required|max:255',
//            'link' => "required|max:255|uniqueCategoryUpdateLinkType:$request->type,$id",
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags" && $key != "itemvote_add" && $key != "itemvote") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
            if (empty($input['link'])) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $category->update($input);
            $category_id = $category->id;
            $itemvote_add = isset($input['itemvote_add']) ? $input['itemvote_add'] : array();
            $itemvote = isset($input['itemvote']) ? $input['itemvote'] : array();
            if (!empty($itemvote)) {
                foreach ($itemvote as $itemvote_value) {
                    $sub_id = (int) $itemvote_value['id'];
                    $input['name'] = trim(filter_var($itemvote_value['answer'], FILTER_SANITIZE_STRING));
                    $input['link'] = str_replace(' ', '_', time() . str_random(8));
                    $input['parent_id'] = $category_id;
                    $input['lang'] = 'ar';
                    if (!empty($input['name']) && !empty($sub_id)) {
                        $sub_category = Category::where('type', 'audience')->find($sub_id);
                        if (isset($sub_category->id)) {
                            $sub_category->update($input);
                        }
                    }
                }
            }
            if (!empty($itemvote_add)) {
                $input['type'] = "audience";
                $input['is_active'] = 1;
                $input['user_id'] = $this->user->id;
                foreach ($itemvote_add as $itemvote_add_value) {
                    $input['name'] = trim(filter_var($itemvote_add_value['answer'], FILTER_SANITIZE_STRING));
                    $input['link'] = str_replace(' ', '_', time() . str_random(8));
                    $input['parent_id'] = $category_id;
                    $input['lang'] = 'ar';
                    if (!empty($input['name'])) {
                        $category_ans = Category::create($input);
                        $category_ans_id = $category_ans['id'];
                        if ($input['lang'] == 'ar') {
                            Category::updateColum($category_ans_id, 'lang_id', $category_ans_id);
                        }
                    }
                }
            }
            Taggable::deleteTaggableType($id, "audience");
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
                        $taggable->insertTaggable($tag_id, $id, "audience");
                    }
                }
            }
            //  return redirect()->route('admin.audiences.index')->with('success', 'Updated successfully');
            return redirect()->back()->with('success', 'Updated successfully');
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

        $category = Category::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.audiences.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Category::where('type', '<>', 'banner')->find($id)->delete();
            Category::deleteParent($id);
            Taggable::deleteTaggableType($id, "audience");
            return redirect()->route('admin.audiences.index')
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
        $type_action = 'مجلس الجمهور';
//        $data = Category::whereIn('type', ['audience','subaudience'])->with('user')->get(); //where('parent_id', 0)->
        $data = Category::where('parent_id', 0)->whereIn('type', ['audience', 'subaudience'])->orderBy('id', 'DESC')->get(); //where('parent_id', 0)->
        return view('admin.audiences.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








