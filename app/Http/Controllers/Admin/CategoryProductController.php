<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\CategoryProduct;
use App\Model\Product;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class CategoryProductController extends AdminController {

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
        $type_action = 'القسم الرئيسى';
        $data = CategoryProduct::where('type', 'product')->where('parent_id', 0)->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.categories_product.index', compact('type_action', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['product'];
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
        if ($type == 'sub') {
            $type_action = 'القسم فرعى';
        } else {
            $type_action = 'القسم الرئيسى';
        }
        $data = CategoryProduct::where('type', 'product')->orderBy('id', 'DESC')->where('type', $type)->paginate($this->limit);  //where('type','<>', 'banner')->
        return view('admin.categories_product.index', compact('type_action', 'data', 'category_create', 'category_edit', 'category_delete'))
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
        $icon = $icon_image = '';
        $lang='ar';
        $link_return = route('admin.categories_product.index');
        return view('admin.categories_product.create', compact('icon','lang', 'icon_image', 'tags', 'link_return', 'new', 'category_active', 'categoryTags'));
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
                return redirect()->route('admin.categories_product.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniqueCategoryProductLinkType:{$request->type}",
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        $input['type'] = "product"; //"main";
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
//        if (!isset($input['is_active'])) {
//            $category_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
//            $input['is_active'] = is_numeric($category_active) ? $category_active : 0;
//        }
        $input['is_active'] = 1;
        $input['user_id'] = $this->user->id;
        $category = CategoryProduct::where('type', 'product')->create($input);
        $category_id = $category['id'];
        if ($input['lang'] == 'ar') {
            CategoryProduct::updateColum($category_id, 'lang_id', $category_id);
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
                    $taggable->insertTaggable($tag_id, $taggable_id, "category_products");
                }
            }
        }
        return redirect()->route('admin.categories_product.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
        $category = CategoryProduct::where('type', '<>', 'banner')->find($id);
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
            $data = CategoryProduct::where('type', '<>', 'banner')->where('parent_id', $id)->where('type', 'sub')->orderBy('id', 'DESC')->paginate($this->limit);
            return view('admin.subcategories_product.index', compact('type_action', 'parent_id', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
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

        $category = CategoryProduct::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.categories_product.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $tags = Tag::pluck('name', 'name');
            $category_active = 1;
            $categoryTags = $category->tags->pluck('name', 'name')->toArray();
            $new = 0;
            $link_return = route('admin.categories_product.index');
            $icon_image = $category->icon_image;
            $icon = $category->icon;
            $lang='ar';
            return view('admin.categories_product.edit', compact('icon','lang', 'icon_image', 'link_return', 'category', 'category_active', 'tags', 'categoryTags', 'new'));
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

        $category = CategoryProduct::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.categories_product.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            $this->validate($request, [
                'name' => 'required|max:255',
//            'link' => "required|max:255|uniqueCategoryProductUpdateLinkType:$request->type,$id",
            ]);


            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

//        $link_count = CategoryProduct::foundLink($input['link']);
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
//          $category_link = new CategoryProduct();
//          $category_link->updateCategoryProductLink($id, $input['link']);
//        }
//        $category = new CategoryProduct();
//        $category->updateCategoryProduct($id, $input['name'], $input['content'], $input['description'], $input['is_active'], $input['parent_id']);

            Taggable::deleteTaggableType($id, "category_products");
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
                        $taggable->insertTaggable($tag_id, $id, "category_products");
                    }
                }
            }
            //  return redirect()->route('admin.categories_product.index')->with('success', 'Updated successfully');
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

        $category = CategoryProduct::where('type', '<>', 'banner')->find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.categories_product.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            CategoryProduct::where('type', '<>', 'banner')->find($id)->delete();
            CategoryProduct::deleteParent($id);
            Taggable::deleteTaggableType($id, "category_products");
            return redirect()->route('admin.categories_product.index')
                            ->with('success', 'CategoryProduct deleted successfully');
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
        $type_action = 'القسم الرئيسى';
//        $data = CategoryProduct::where('type','<>', 'banner')->with('user')->where('parent_id', 0)->get();
        $data = CategoryProduct::where('type', '<>', 'banner')->where('parent_id', 0)->orderBy('id', 'DESC')->get();
        return view('admin.categories_product.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
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
        $type_action = 'القسم الرئيسى';
//        $data = CategoryProduct::where('type','<>', 'banner')->with('user')->get();
        $data = CategoryProduct::where('type', '<>', 'banner')->get();
        return view('admin.categories_product.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








