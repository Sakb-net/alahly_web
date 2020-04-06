<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Category;
use App\User;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class SubteamController extends AdminController {

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
        $type_action = 'الفريق الفرعى';
        $data = Category::where('parent_id', '<>', 0)->where('type', 'subteam')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.subteams.index', compact('type_action', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create($id = null) {
        $parent_id = $id;
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
        $categories_all = Category::where('type', 'team')->where('parent_id', 0)->where('is_active', 1)->pluck('id', 'name')->toArray();
        $first_title = ['اختر الفريق الرئيسى' => 0];
        $categories = array_flip(array_merge($first_title, $categories_all));
        $new = 1;
        $icon = $icon_image = '';
        if (!empty($parent_id)) {
            $link_return = route('admin.clubteams.show', $parent_id);
        } else {
            $link_return = route('admin.subclubteams.index');
        }
        $lang='ar';
        return view('admin.subteams.create', compact('parent_id','lang', 'icon', 'link_return', 'icon_image', 'tags', 'new', 'categories', 'category_active', 'categoryTags'));
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
                return redirect()->route('admin.subclubteams.index')->with('error', 'Have No Access');
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
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        $input['type'] = "subteam";
        if (empty($input['link'])) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        if (!isset($input['is_active'])) {
//            $category_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
            $input['is_active'] = 1; //is_numeric($category_active) ? $category_active : 0;
        }
        $input['user_id'] = $this->user->id;
        $category = Category::create($input);
        $category_id = $category['id'];
        if ($input['lang'] == 'ar') {
            Category::updateColum($category_id, 'lang_id', $category_id);
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
                    $taggable->insertTaggable($tag_id, $taggable_id, "team");
                }
            }
        }
        if (!empty($input['parent_id'])) {
            return redirect()->route('admin.clubteams.show', $input['parent_id'])->with('success', 'Created successfully');
        } else {
            return redirect()->route('admin.subclubteams.index')->with('success', 'Created successfully');
        }
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
 public function show(Request $request, $id) {
        $category = Category::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
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
            $parent_id = $id;
            $type_action = 'لاعبين الفريق';
            $data = Category::where('parent_id', $id)->where('type', 'userteam')->orderBy('id', 'DESC')->paginate($this->limit);
            return view('admin.userteams.index', compact('type_action', 'parent_id', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
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

        $category = Category::find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.subclubteams.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $tags = Tag::pluck('name', 'name');
            $category_active = 1;
            $categoryTags = $category->tags->pluck('name', 'name')->toArray();
            $categories_all = Category::where('type', 'team')->where('parent_id', 0)->where('is_active', 1)->where('id', '<>', $id)->pluck('id', 'name')->toArray();
            $first_title = ['اختر الفريق الرئيسى' => 0];
            $categories = array_flip(array_merge($first_title, $categories_all));
            $new = 0;
            $icon_image = $category->icon_image;
            $icon = $category->icon;
            $parent_id =$category->parent_id;
            if (!empty($category->parent_id)) {
                $link_return = route('admin.clubteams.show', $category->parent_id);
            } else {
                $link_return = route('admin.subclubteams.index');
            }
            $lang='ar';
            return view('admin.subteams.edit', compact('icon','lang','parent_id', 'icon_image', 'link_return', 'category', 'categories', 'category_active', 'tags', 'categoryTags', 'new'));
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

        $category = Category::find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.subclubteams.index')->with('error', 'Have No Access');
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
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

//        $link_count = Category::foundLink($input['link']);
//        if($link_count > 0){
//          $input['link'] = $category->link;  
//        }else{
//            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
//        }
            if (empty($input['link'])) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $category->update($input);

//        if($link_count == 0){
//          $input['link'] = $category->link;  
//          $category_link = new Category();
//          $category_link->updateCategoryLink($id, $input['link']);
//        }
//        $category = new Category();
//        $category->updateCategory($id, $input['name'], $input['content'], $input['description'], $input['is_active'], $input['parent_id']);

            Taggable::deleteTaggableType($id, "team");
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
                        $taggable->insertTaggable($tag_id, $id, "team");
                    }
                }
            }
            if (!empty($input['parent_id'])) {
                return redirect()->route('admin.clubteams.show', $input['parent_id'])->with('success', 'Updated successfully');
            } else {
                return redirect()->route('admin.subclubteams.index')->with('success', 'Updated successfully');
            }
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

        $category = Category::find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.subclubteams.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Category::find($id)->delete();
            Taggable::deleteTaggableType($id, "categories");
            return redirect()->route('admin.subclubteams.index')
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
        $type_action = 'الفريق الفرعى';
//        $data = Category::with('user')->where('parent_id','<>', 0)->where('type', 'subteam')->get();
        $data = Category::where('parent_id', '<>', 0)->where('type', 'subteam')->get();
        return view('admin.subteams.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








