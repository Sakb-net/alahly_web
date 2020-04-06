<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\CategoryProduct;
use App\Model\Product;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class SubcategoryProductController extends AdminController {

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
        $type_action = 'القسم الفرعى';
        $data = CategoryProduct::where('parent_id', '<>', 0)->where('type', 'sub')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.subcategories_product.index', compact('type_action', 'data', 'category_active', 'category_create', 'category_edit', 'category_show', 'category_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
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
        $categories_all = CategoryProduct::where('type', 'product')->where('parent_id', 0)->where('is_active', 1)->pluck('id', 'name')->toArray();
        $first_title = ['اختر القسم الرئيسى' => 0];
        $categories = array_flip(array_merge($first_title, $categories_all));
        $new = 1;
        $icon = $icon_image = '';
        if (!empty($parent_id)) {
            $link_return = route('admin.categories_product.show', $parent_id);
        } else {
            $link_return = route('admin.subcategories_product.index');
        }
        $lang='ar';
        return view('admin.subcategories_product.create', compact('parent_id','lang', 'icon', 'link_return', 'icon_image', 'tags', 'new', 'categories', 'category_active', 'categoryTags'));
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
                return redirect()->route('admin.subcategories_product.index')->with('error', 'Have No Access');
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

        $input['type'] = "sub";
        if (empty($input['link'])) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        if (!isset($input['is_active'])) {
//            $category_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
            $input['is_active'] = 1; //is_numeric($category_active) ? $category_active : 0;
        }
        $input['user_id'] = $this->user->id;
        $category = CategoryProduct::create($input);
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
                    $taggable->insertTaggable($tag_id, $taggable_id, "categories");
                }
            }
        }
        if (!empty($input['parent_id'])) {
            return redirect()->route('admin.categories_product.show', $input['parent_id'])->with('success', 'Subcategory created successfully');
        } else {
            return redirect()->route('admin.subcategories_product.index')->with('success', 'Subcategory created successfully');
        }
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
//        $category = CategoryProduct::find($id);
        return redirect()->route('admin.subcategories_product.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        $category = CategoryProduct::find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.subcategories_product.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $tags = Tag::pluck('name', 'name');
            $category_active = 1;
            $categoryTags = $category->tags->pluck('name', 'name')->toArray();
            $categories_all = CategoryProduct::where('type', 'product')->where('parent_id', 0)->where('is_active', 1)->where('id', '<>', $id)->pluck('id', 'name')->toArray();
            $first_title = ['اختر القسم الرئيسى' => 0];
            $categories = array_flip(array_merge($first_title, $categories_all));
            $new = 0;
            $icon_image = $category->icon_image;
            $icon = $category->icon;
            $parent_id =$category->parent_id;
            if (!empty($category->parent_id)) {
                $link_return = route('admin.categories_product.show', $category->parent_id);
            } else {
                $link_return = route('admin.subcategories_product.index');
            }
            $lang='ar';
            return view('admin.subcategories_product.edit', compact('icon','lang','parent_id', 'icon_image', 'link_return', 'category', 'categories', 'category_active', 'tags', 'categoryTags', 'new'));
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

        $category = CategoryProduct::find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-edit'])) {
                if ($this->user->can(['category-list', 'category-create'])) {
                    return redirect()->route('admin.subcategories_product.index')->with('error', 'Have No Access');
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
//          $category_link = new Category();
//          $category_link->updateCategoryLink($id, $input['link']);
//        }
//        $category = new Category();
//        $category->updateCategory($id, $input['name'], $input['content'], $input['description'], $input['is_active'], $input['parent_id']);

            Taggable::deleteTaggableType($id, "categories");
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
                        $taggable->insertTaggable($tag_id, $id, "categories");
                    }
                }
            }
            if (!empty($input['parent_id'])) {
                return redirect()->route('admin.categories_product.show', $input['parent_id'])->with('success', 'Subcategory updated successfully');
            } else {
                return redirect()->route('admin.subcategories_product.index')->with('success', 'Subcategory updated successfully');
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

        $category = CategoryProduct::find($id);
        if (!empty($category)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'category-all', 'category-delete'])) {
                if ($this->user->can(['category-list', 'category-edit'])) {
                    return redirect()->route('admin.subcategories_product.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            CategoryProduct::find($id)->delete();
            Taggable::deleteTaggableType($id, "categories");
            return redirect()->route('admin.subcategories_product.index')
                            ->with('success', 'Subcategory deleted successfully');
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
        $type_action = 'القسم الفرعى';
//        $data = CategoryProduct::with('user')->where('parent_id','<>', 0)->where('type', 'sub')->get();
        $data = CategoryProduct::where('parent_id', '<>', 0)->where('type', 'sub')->get();
        return view('admin.subcategories_product.search', compact('type_action', 'data', 'category_create', 'category_edit', 'category_show', 'category_active', 'category_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








