<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Category;
use App\User;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class ChampionController extends AdminController {

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
        $type_action = 'البطولات';
        $data = Category::where('type', 'champion')->orderBy('id', 'DESC')->paginate($this->limit); //where('parent_id','<>', 0)->
        return view('admin.champions.index', compact('type_action', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['champion'];
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
        $type_action = 'البطولات';
        $data = Category::where('type', 'champion')->orderBy('id', 'DESC')->where('type', $type)->paginate($this->limit);  //where('type','<>', 'banner')->
        return view('admin.champions.index', compact('type_action', 'data', 'category_create', 'category_edit', 'category_delete'))
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
        $categoryTags = $cat_teams = $cat_subteams = $subteams = [];
        //team
        $categories_all = Category::cateorySelect(0, 'team', 'lang', $lang, 1);
        if ($this->user->lang == 'ar') {
            $first_title = ['اختر الفريق ' => 0];
        } else {
            $first_title = ['Choose Team' => 0];
        }
        $teams = array_flip(array_merge($first_title, $categories_all));
        $new = 1;
        $icon = $icon_image = '';
        $link_return = route('admin.champions.index');
        return view('admin.champions.create', compact('icon', 'subteams', 'cat_subteams', 'lang', 'teams', 'cat_teams', 'icon_image', 'tags', 'link_return', 'new', 'category_active', 'categoryTags'));
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
                return redirect()->route('admin.champions.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        if (!empty($request->parent_id)) {
            $this->validate($request, [
                'name' => 'required|max:255',
//            'link' => "max:255|uniqueCategoryLinkType:{$request->type}",
                'parent_id' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

            $input['type'] = "champion"; //"main";
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
                        $taggable->insertTaggable($tag_id, $taggable_id, "champion");
                    }
                }
            }
            return redirect()->route('admin.champions.index')->with('success', 'Created successfully');
        } else {
            return redirect()->route('admin.champions.create')->with('error', 'Not Save');
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
            $type_action = 'القسم الفرعى';
            $data = Category::where('type', '<>', 'banner')->where('parent_id', $id)->where('type', 'subchampion')->orderBy('id', 'DESC')->paginate($this->limit);
            return view('admin.subchampions.index', compact('type_action', 'parent_id', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
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
        $category = Category::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.champions.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $lang = 'ar';
            $tags = Tag::pluck('name', 'name');
            $category_active = 1;
            $categoryTags = $category->tags->pluck('name', 'name')->toArray();
            //team
            $cat_subteams = $subteams = [];
            $cat_teams = [$category->parent_id => $category->parent_id];
            $categories_all = Category::cateorySelect(0, 'team', 'lang', $lang, 1);
            if ($this->user->lang == 'ar') {
                $first_title = ['اختر الفريق ' => 0];
            } else {
                $first_title = ['Choose Team' => 0];
            }
            $teams = array_flip(array_merge($first_title, $categories_all));
            $data_subcat = Category::get_categoryID($category->parent_id, 'name', 1);
            if (isset($data_subcat->parent_id)) {
                if ($data_subcat->parent_id > 0) {
                    $data_cat = Category::get_categoryID($data_subcat->parent_id, 'name', 1);
                    $cat_subteams = $cat_teams;
                    $cat_teams = [$data_cat->id => $data_cat->id];
                    $subteams_all = Category::where('type', 'subteam')->where('parent_id', $data_cat->id)->where('is_active', 1)->pluck('id', 'name')->toArray();
                    if ($this->user->lang == 'ar') {
                        $first_title = ['اختر الفريق الفرعى ' => 0];
                    } else {
                        $first_title = ['Choose Sub Team' => 0];
                    }
                    $subteams = array_flip(array_merge($first_title, $subteams_all));
                }
            }
            $new = 0;
            $link_return = route('admin.champions.index');
            $icon_image = $category->icon_image;
            $icon = $category->icon;
            return view('admin.champions.edit', compact('icon', 'teams', 'cat_teams', 'cat_subteams', 'subteams', 'lang', 'icon_image', 'link_return', 'category', 'category_active', 'tags', 'categoryTags', 'new'));
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
        $category = Category::where('type','champion')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.champions.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            if (!empty($request->parent_id)) {

                $this->validate($request, [
                    'name' => 'required|max:255',
//            'link' => "required|max:255|uniqueCategoryUpdateLinkType:$request->type,$id",
                    'parent_id' => 'required',
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

                Taggable::deleteTaggableType($id, "champion");
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
                            $taggable->insertTaggable($tag_id, $id, "champion");
                        }
                    }
                }
                //  return redirect()->route('admin.champions.index')->with('success', 'Updated successfully');
                return redirect()->back()->with('success', 'Updated successfully');
            } else {
                return redirect()->route('admin.champions.edit', $id)->with('error', 'Not Save');
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

        $category = Category::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.champions.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Category::where('type', '<>', 'banner')->find($id)->delete();
            Category::deleteParent($id);
            Taggable::deleteTaggableType($id, "champion");
            return redirect()->route('admin.champions.index')
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
        $type_action = 'البطولات';
//        $data = Category::whereIn('type', ['champion','subchampion'])->with('user')->get(); //where('parent_id', 0)->
        $data = Category::whereIn('type', ['champion', 'subchampion'])->orderBy('id', 'DESC')->get(); //where('parent_id', 0)->
        return view('admin.champions.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

    public function allSearch() {

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
        $type_action = 'البطولات';
//        $data = Category::whereIn('type', ['champion','subchampion'])->with('user')->get();
        $data = Category::whereIn('type', ['champion', 'subchampion'])->get();
        return view('admin.champions.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








