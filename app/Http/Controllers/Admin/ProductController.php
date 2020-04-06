<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Product;
use App\Model\CategoryProduct;
use App\Model\Fees;
use App\Model\CategoryProductProduct;
use App\Model\Tag;
use App\Model\Taggable;
use App\Model\CommentProduct;
use DB;

class ProductController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-list', 'product-edit', 'product-delete', 'product-show'])) {
            return $this->pageUnauthorized();
        }

        $product_active = $product_edit = $product_create = $product_delete = $product_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'product-type-all', 'product-all'])) {
            $product_active = $product_edit = $product_create = $product_delete = $product_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('product-edit')) {
            $product_active = $product_edit = $product_create = $product_show = 1;
        }

        if ($this->user->can('product-delete')) {
            $product_delete = 1;
        }

        if ($this->user->can('product-show')) {
            $product_show = 1;
        }

        if ($this->user->can('product-create')) {
            $product_create = 1;
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
        $name = 'product';
        $type_action = 'Product';
        $type_name = '';
        $data = Product::with('categories')->orderBy('id', 'DESC')->where('type', 'product')->paginate($this->limit);
//        $data = Product::orderBy('id', 'DESC')->with('user')->where('type', 'product')->paginate($this->limit);
        return view('admin.products.index', compact('type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'product_active', 'product_create', 'product_edit', 'product_delete', 'product_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {
        $type_name = trans('app.products');
        $type_array = ['product'];
        if (!in_array($type, $type_array)) {
            return $this->pageUnauthorized();
        }

        if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-list', 'product-edit', 'product-delete', 'product-show'])) {
            return $this->pageUnauthorized();
        }

        $product_active = $product_edit = $product_create = $product_delete = $product_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'product-type-all', 'product-all'])) {
            $product_active = $product_edit = $product_create = $product_delete = $product_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('product-edit')) {
            $product_active = $product_edit = $product_create = $product_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('product-delete')) {
            $product_delete = 1;
        }

        if ($this->user->can('product-show')) {
            $product_show = 1;
        }

        if ($this->user->can('product-create')) {
            $product_create = 1;
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

        $data = Product::whereHas('categories', function ($q)use($type) {
                    $q->where('is_active', 1)->where('type', '=', $type);
                })->paginate($this->limit);
//                Product::orderBy('id', 'DESC')->with('user')->where('type', $type)->paginate($this->limit);
        return view('admin.products.indexSection', compact('type', 'type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'product_create', 'product_edit', 'product_active', 'product_delete', 'product_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create(Request $request) {
        $type = 'product';
        $type_name = trans('app.products');
        $type_array = ['product'];
        if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-create', 'product-edit'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');

        if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit'])) {
            $product_active = $image = 1;
        } else {
            $product_active = $image = 0;
        }
        if ($this->user->can(['image-upload', 'image-edit'])) {
            $image = 1;
        }
        $lang = 'ar';
        //category
        $categories_all = CategoryProduct::cateorySelect(0, 'product', 'lang', $lang, 1);
        $fees_all = Fees::get_fees_ISActive(1, 1, [1, 2]);
        if ($this->user->lang == 'ar') {
            $first_title = ['اختر القسم الرئيسى' => 0];
            $fees_title = ['اختر رسوم المنتج ' => 0];
        } else {
            $first_title = ['Choose Category' => 0];
            $fees_title = ['Choose Fees' => 0];
        }
        $categories = array_flip(array_merge($first_title, $categories_all));
        $fees = array_flip(array_merge($fees_title, $fees_all));
        $dec_prod = $productCategories = $productTags = $subcategories = $all_brand = $all_fees = $weight = $color = [];
        $new = 1;
        $image_link = $city_made = NULL;
        $link_return = route('admin.products.index');
        return view('admin.products.create', compact('weight', 'color', 'city_made', 'dec_prod', 'all_brand', 'all_fees', 'fees', 'subcategories', 'type_name', 'lang', 'type', 'link_return', 'tags', 'productTags', 'categories', 'productCategories', 'new', 'product_active', 'image', 'image_link'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-create', 'product-edit'])) {
            if ($this->user->can(['product-list'])) {
                return redirect()->route('admin.products.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        if (empty($request['category_id']) || $request['category_id'] == 0 || $request['category_id'] == '0') {
            $request['category_id'] = null;
        }
        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniqueProductLinkType:{$request->type}",
            'category_id' => 'required',
        ]);
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "decProd_add" && $key != "weight" && $key != "color" && $key != "category_id" && $key != "description" && $key != "content" && $key != "tags" && $key != "products" && $key != "brand_add" && $key != "fees_add") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $input['is_read'] = 1;
        $input['is_active'] = 1;

        if (!isset($input['is_comment'])) {
            $input['is_comment'] = $input['is_active'];
        }
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        $brand_add = isset($_POST['brand_add']) ? $_POST['brand_add'] : array();
        $fees_add = isset($_POST['fees_add']) ? $_POST['fees_add'] : array();
        $decProd_add = isset($_POST['decProd_add']) ? $_POST['decProd_add'] : array();
        $data_image = $data_fees = [];
        if (!empty($brand_add)) {
            foreach ($brand_add as $brand_add_value) {
                $value_image = trim(filter_var($brand_add_value['value_image'], FILTER_SANITIZE_STRING));
                if (!empty($value_image)) {
                    $data_image[] = $value_image;
                }
            }
        }
        if (!empty($fees_add)) {
            foreach ($fees_add as $fees_add_value) {
                $val_fees = trim(filter_var($fees_add_value['fees_id'], FILTER_SANITIZE_STRING));
                if (!empty($val_fees)) {
                    $data_fees[] = $val_fees;
                }
            }
        }
        $data_dec_prod = [];
        $min_price = $min_discount = 0.00;
        if (!empty($decProd_add)) {
            foreach ($decProd_add as $key_prodadd => $decProd_add_value) {
                $val_prod['weight'] = trim(filter_var($decProd_add_value['weight'], FILTER_SANITIZE_STRING));
                $val_prod['code'] = trim(filter_var($decProd_add_value['code'], FILTER_SANITIZE_STRING));
                $price = trim(filter_var($decProd_add_value['price'], FILTER_SANITIZE_STRING));
                if ($price <= 0) {
                    $price = 0;
                }
                $val_prod['price'] = $price;
                $discount = trim(filter_var($decProd_add_value['discount'], FILTER_SANITIZE_STRING));
                if ($discount <= 0) {
                    $discount = 0;
                }
                $val_prod['discount'] = $discount;
                if (!empty($val_prod['weight']) && !empty($val_prod['code']) && $val_prod['price'] > 0) {
                    if ($key_prodadd == 0) {
                        $min_price = $val_prod['price'];
                        $min_discount = $val_prod['discount'];
                    } elseif ($min_price > $val_prod['price']) {
                        $min_price = $val_prod['price'];
                        $min_discount = $val_prod['discount'];
                    }
                    $data_dec_prod[] = $val_prod;
                }
            }
        }
        $input['discount'] = $min_discount;
        $input['price'] = $min_price;
        if (!isset($input['number_prod']) || empty($input['number_prod'])) {
            $input['number_prod'] = 0;
        }
        if (!isset($input['sale_number_prod']) || empty($input['sale_number_prod'])) {
            $input['sale_number_prod'] = 0;
        }
        if (!isset($input['color']) || empty($input['color'])) {
            $input['color'] = [];
        }
        $content_array = array('dec_prod' => $data_dec_prod,
            'color' => $input['color'], 'city_made' => $input['city_made']);

        $input['content'] = json_encode($content_array, true);
        $input['fees_id'] = json_encode($data_fees, true);
        $input['another_image'] = json_encode($data_image, true);
        $input['user_id'] = $this->user->id;
        $input['update_by'] = $this->user->id;
        $category_id = (int) $input['category_id'];

        $product = Product::create($input);
        $product_id = $product['id'];
        if ($input['lang'] == 'ar') {
            Product::updateColum($product_id, 'lang_id', $product_id);
        }
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
                    $taggable_id = Taggable::foundTaggable($tag_id, $product_id, "product");
                    if ($taggable_id == 0) {
                        $taggable->insertTaggable($tag_id, $product_id, "product");
                    }
                }
            }
        }
        //single category
        $product_category = new CategoryProductProduct();
        if ($category_id > 0) {
            $product_category->insertCategoryProductProduct($category_id, $product_id);
        }
        return redirect()->route('admin.products.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show($id) {
//        $product = Product::find($id);
        return redirect()->route('admin.products.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $product = Product::find($id);
        $type = 'product';
        $type_name = trans('app.products');
        if (!empty($product)) {
            if ($this->user->id != $product->user_id) {
                if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit', 'product-edit-only'])) {
                    if ($this->user->can(['product-list', 'product-create'])) {
                        return redirect()->route('admin.products.index')->with('error', 'Have No Access');
                    } else {
                        return $product->pageUnauthorized();
                    }
                }
            }
            if ($this->user->can('product-edit-only') && !$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['product-list', 'product-create'])) {
                        return redirect()->route('admin.products.index')->with('error', 'Have No Access');
                    } else {
                        return $product->pageUnauthorized();
                    }
                }
            }
            $image = $new = 0;
            if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit'])) {
                $product_active = $image = 1;
            } else {
                $product_active = 0;
            }
            if ($this->user->can(['image-edit'])) {
                $image = 1;
            }
            $image_link = $product->image;
            if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit'])) {
                $product_active = 1;
            } else {
                $product_active = 0;
            }
            if ($product_active == 1) {
                $product->updateColum($id, 'is_read', 1);
            }
            $lang = 'ar';
            $tags = Tag::pluck('name', 'name');
//            $productTags = $product->tags->pluck('name', 'name')->toArray();
            $productTags = Tag::whereIn('id', function($query)use ($id) {
                        $query->select('tag_id')
                                ->from(with(new Taggable)->getTable())
                                ->where('is_search', 1)->where('taggable_id', '=', $id)->where('taggable_type', '=', 'product');
                    })->pluck('name', 'name')->toArray();
            //category
            $productCategories = 0;
            if (isset($product->categories[0]->id)) {
                $productCategories = $product->categories[0]->id; //pluck('id', 'id'); //->toArray();
            }
            $productSubcategories = NULL;
            $categories_all = CategoryProduct::cateorySelect(0, 'product', 'lang', $lang, 1);
            $fees_all = Fees::get_fees_ISActive(1, 1, [1, 2]);
            if ($this->user->lang == 'ar') {
                $first_title = ['اختر القسم الرئيسى' => 0];
                $fees_title = ['اختر رسوم المنتج ' => 0];
            } else {
                $first_title = ['Choose Category' => 0];
                $fees_title = ['Choose Fees' => 0];
            }
            $categories = array_flip(array_merge($first_title, $categories_all));
            $fees = array_flip(array_merge($fees_title, $fees_all));
            if (isset($product->categories[0]->parent_id) && $product->categories[0]->parent_id != 0) {
                $productSubcategories = $productCategories;
                $productCategories = CategoryProduct::where('type', 'product')->where('id', $product->categories[0]->parent_id)->pluck('id', 'id');
                $subcategories_all = CategoryProduct::where('type', 'sub')->where('parent_id', $product->categories[0]->parent_id)->where('is_active', 1)->pluck('id', 'name')->toArray();
                if ($this->user->lang == 'ar') {
                    $first_title = ['اختر القسم الفرعى' => 0];
                } else {
                    $first_title = ['Choose subCategory' => 0];
                }
                $subcategories = array_flip(array_merge($first_title, $subcategories_all));
            } else {
                $subcategories = array();
            }
            $weight = $color = $dec_prod = [];
            $city_made = NULL;
            $content = json_decode($product->content, true);
            foreach ($content as $key => $val_res) {
                $$key = $val_res;
            }
//            print_r($dec_prod);die;
            if (!empty($color)) {
                $color = ValueKeyArray($color);
            }
            $all_brand = json_decode($product->another_image, true);
            $all_fees = json_decode($product->fees_id, true);
            $link_return = route('admin.products.index');
            return view('admin.products.edit', compact('dec_prod', 'weight', 'color', 'city_made', 'all_brand', 'all_fees', 'fees', 'subcategories', 'productSubcategories', 'lang', 'type', 'type_name', 'link_return', 'product', 'productTags', 'productCategories', 'tags', 'categories', 'new', 'image', 'image_link', 'product_active'));
        } else {
            return $product->pageError();
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
        $product = Product::find($id);
        $image = 0;
        if (!empty($product)) {
            if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit', 'product-edit-only'])) {
                if ($this->user->can(['product-list', 'product-create'])) {
                    return redirect()->route('admin.products.index')->with('error', 'Have No Access');
                } else {
                    return $product->pageUnauthorized();
                }
            }

            if ($this->user->can('product-edit-only') && !$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['product-list', 'product-create'])) {
                        return redirect()->route('admin.products.index')->with('error', 'Have No Access');
                    } else {
                        return $product->pageUnauthorized();
                    }
                }
            } $this->validate($request, [
                'name' => 'required|max:255',
//                    'link' => "max:255|uniqueProductUpdateLinkType:$request->type,$id",
                'category_id' => 'required',
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "decProd" && $key != "decProd_add" && $key != "weight" && $key != "color" && $key != "category_id" && $key != "description" && $key != "content" && $key != "tags" && $key != "products" && $key != "brand_add" && $key != "fees_add" && $key != "brand" && $key != "fees") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
            if ($input['link'] == Null) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $input['update_by'] = $this->user->id;
            $brand_add = isset($_POST['brand_add']) ? $_POST['brand_add'] : array();
            $brand = isset($_POST['brand']) ? $_POST['brand'] : array();
            $fees_add = isset($_POST['fees_add']) ? $_POST['fees_add'] : array();
            $fees = isset($_POST['fees']) ? $_POST['fees'] : array();
            $decProd_add = isset($_POST['decProd_add']) ? $_POST['decProd_add'] : array();
            $decProd = isset($_POST['decProd']) ? $_POST['decProd'] : array();
            $data_image = $data_fees = [];
            if (!empty($brand)) {
                foreach ($brand as $brand_value) {
                    $value_image = trim(filter_var($brand_value['value_image'], FILTER_SANITIZE_STRING));
                    if (!empty($value_image)) {
                        $data_image[] = $value_image;
                    }
                }
            }
            if (!empty($brand_add)) {
                foreach ($brand_add as $brand_add_value) {
                    $value_image = trim(filter_var($brand_add_value['value_image'], FILTER_SANITIZE_STRING));
                    if (!empty($value_image)) {
                        $data_image[] = $value_image;
                    }
                }
            }
            if (!empty($fees)) {
                foreach ($fees as $fees_value) {
                    $val_fees = trim(filter_var($fees_value['fees_id'], FILTER_SANITIZE_STRING));
                    if (!empty($val_fees)) {
                        $data_fees[] = $val_fees;
                    }
                }
            }
            if (!empty($fees_add)) {
                foreach ($fees_add as $fees_add_value) {
                    $val_fees = trim(filter_var($fees_add_value['fees_id'], FILTER_SANITIZE_STRING));
                    if (!empty($val_fees)) {
                        $data_fees[] = $val_fees;
                    }
                }
            }
            $data_dec_prod = [];
            $min_price = $min_discount = 0.00;
            if (!empty($decProd_add)) {
                foreach ($decProd_add as $key_prodadd => $decProd_add_value) {
                    $val_prod['weight'] = trim(filter_var($decProd_add_value['weight'], FILTER_SANITIZE_STRING));
                    $val_prod['code'] = trim(filter_var($decProd_add_value['code'], FILTER_SANITIZE_STRING));
                    $price = trim(filter_var($decProd_add_value['price'], FILTER_SANITIZE_STRING));
                    if ($price <= 0) {
                        $price = 0;
                    }
                    $val_prod['price'] = $price;
                    $discount = trim(filter_var($decProd_add_value['discount'], FILTER_SANITIZE_STRING));
                    if ($discount <= 0) {
                        $discount = 0;
                    }
                    $val_prod['discount'] = $discount;
                    if (!empty($val_prod['weight']) && !empty($val_prod['code']) && $val_prod['price'] > 0) {
                        if ($key_prodadd == 0) {
                            $min_price = $val_prod['price'];
                            $min_discount = $val_prod['discount'];
                        } elseif ($min_price > $val_prod['price']) {
                            $min_price = $val_prod['price'];
                            $min_discount = $val_prod['discount'];
                        }
                        $data_dec_prod[] = $val_prod;
                    }
                }
            }
            if (!empty($decProd)) {
                foreach ($decProd as $key_prod => $decProd_value) {
                    $val_prod['weight'] = trim(filter_var($decProd_value['weight'], FILTER_SANITIZE_STRING));
                    $val_prod['code'] = trim(filter_var($decProd_value['code'], FILTER_SANITIZE_STRING));
                    $price = trim(filter_var($decProd_value['price'], FILTER_SANITIZE_STRING));
                    if ($price <= 0) {
                        $price = 0;
                    }
                    $val_prod['price'] = $price;
                    $discount = trim(filter_var($decProd_value['discount'], FILTER_SANITIZE_STRING));
                    if ($discount <= 0) {
                        $discount = 0;
                    }
                    $val_prod['discount'] = $discount;
                    if (!empty($val_prod['weight']) && !empty($val_prod['code']) && $val_prod['price'] > 0) {
                        if ($key_prod == 0 && $min_price <= 0) {
                            $min_price = $val_prod['price'];
                            $min_discount = $val_prod['discount'];
                        } elseif ($min_price > $val_prod['price']) {
                            $min_price = $val_prod['price'];
                            $min_discount = $val_prod['discount'];
                        }
                        $data_dec_prod[] = $val_prod;
                    }
                }
            }
            $input['discount'] = $min_discount;
            $input['price'] = $min_price;
            if (!isset($input['color']) || empty($input['color'])) {
                $input['color'] = [];
            }
            $content_array = array('dec_prod' => $data_dec_prod,
                'color' => $input['color'], 'city_made' => $input['city_made']);

            $input['content'] = json_encode($content_array, true);
            $input['fees_id'] = json_encode($data_fees, true);
            $input['another_image'] = json_encode($data_image, true);

            $product->update($input);
            $product_id = $product->id;
            $category_id = (int) $input['category_id'];
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
                        $taggable_id = Taggable::foundTaggable($tag_id, $product->id, "product");
                        if ($taggable_id == 0) {
                            $taggable->insertTaggable($tag_id, $product->id, "product");
                        }
                    }
                }
            }
//single category
            CategoryProductProduct::deleteProduct($id);
            $product_category = new CategoryProductProduct();
            if ($category_id > 0) {
                $product_category->insertCategoryProductProduct($category_id, $id);
            }

            if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit'])) {
                return redirect()->route('admin.products.index')
                                ->with('success', 'Updated successfully');
            } elseif ($this->user->can('product-edit-only')) {
                return redirect()->route('admin.users.index')->with('success', 'Updated successfully');
//                return redirect()->route('admin.users.producttype', [$this->user->id, 'product'])->with('success', 'Updated successfully');
            }
        } else {
            return $product->pageError();
        }
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function destroy($id) {
        $product = Product::find($id);
        if (!empty($product)) {
            if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-delete', 'product-delete-only'])) {
                if ($this->user->can(['product-list'])) {
                    return redirect()->route('admin.products.index')->with('error', 'Have No Access');
                } else {
                    return $product->pageUnauthorized();
                }
            }

            if ($this->user->can('product-delete-only') && !$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-delete'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['product-list'])) {
                        return redirect()->route('admin.products.index')->with('error', 'Have No Access');
                    } else {
                        return $product->pageUnauthorized();
                    }
                }
            }
            $typeCat = $product->type; //$product->categories[0]['type'];
            Taggable::deleteTaggableType($id, $product->type);
            Product::find($id)->delete();
            if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'product-delete'])) {
                return redirect()->route('admin.products.index')
                                ->with('success', 'Deleted successfully');
            } elseif ($this->user->can(['product-delete-only'])) {
                return redirect()->route('admin.users.index')->with('success', 'Product deleted successfully');
//                return redirect()->route('admin.users.producttype', [$this->user->id, 'products'])->with('success', 'Product deleted successfully');
            }
        } else {
            return $product->pageError();
        }
    }

    public function search(Request $request) {
        $type = 'product';
        $type_name = trans('app.products');
        $type_array = ['product'];

        $type_action = $type_name;
        if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-list', 'product-edit', 'product-delete', 'product-show'])) {
            return $product->pageUnauthorized();
        }

        $product_active = $product_edit = $product_create = $product_delete = $product_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'product-type-all', 'product-all'])) {
            $product_active = $product_edit = $product_create = $product_delete = $product_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('product-edit')) {
            $product_active = $product_edit = $product_create = $product_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('product-delete')) {
            $product_delete = 1;
        }

        if ($this->user->can('product-show')) {
            $product_show = 1;
        }

        if ($this->user->can('product-create')) {
            $product_create = 1;
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
        $name = 'products';
        $data = Product::get();
        return view('admin.products.search', compact('type', 'type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'product_active', 'product_create', 'product_edit', 'product_delete', 'product_show'));
    }

///*****************  comment for product ***********************************
    public function comments(Request $request, $id) {
        $product = Product::find($id);
        if (!empty($product)) {
            if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit', 'product-edit-only', 'product-show', 'product-show-only'])) {
                if ($this->user->can(['product-list', 'product-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.' . $product->type . 's.index');
                } else {
                    return $product->pageUnauthorized();
                }
            }
            if ($this->user->can(['product-edit-only', 'product-show-only']) && !$this->user->can(['access-all', 'product-type-all', 'product-all', 'product-edit', 'product-show'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['product-list', 'product-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.' . $product->type . 's.index');
                    } else {
                        return $product->pageUnauthorized();
                    }
                }
            }

            if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'comment-all', 'comment-list', 'comment-edit', 'comment-delete'])) {
                return $product->pageUnauthorized();
            }

            $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 0;

            if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'comment-all'])) {
                $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-edit', 'comment-edit-product-only'])) {
                $comment_active = $comment_edit = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-delete', 'comment-delete-product-only'])) {
                $comment_delete = 1;
            }

            if ($this->user->can('comment-create')) {
                $comment_create = 1;
            }

            $name = $product->type;
            $type_action = '';
            $data = CommentProduct::where('product_id', $id)->paginate($this->limit);  //where('type','question')->
            $link_return = route('admin.products.index'); //route('admin.products.comments.index',$id);
            return view('admin.productcomments.index', compact('link_return', 'product', 'type_action', 'data', 'id', 'name', 'comment_create', 'comment_list', 'comment_active', 'comment_edit', 'comment_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function commentCreate($id) {

        $product = Product::find($id);
        if (!empty($product)) {
            if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                return $product->pageUnauthorized();
            }
            $users = User::pluck('id', 'name');
            $comment_active = $user_active = 0;
            if ($this->user->can(['access-all', 'product-type-all', 'product-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $new = 1;
            $user_id = $this->user->id;
            $link_return = route('admin.products.comments.index', $product->id);
            return view('admin.productcomments.create', compact('users', 'product', 'link_return', 'user_id', 'id', 'new', 'comment_active'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function commentStore(Request $request, $id) {
        $product = Product::find($id);
        if (!empty($product)) {
            if (!$this->user->can(['access-all', 'product-type-all', 'product-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                if ($this->user->can(['product-list'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.' . $product->type . 's.index');
                } else {
                    return $product->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $input['type'] = $product->type;
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
            if (empty($user_image)) {
                $user_image = '/images/user.png';
            }
            $visitor = $request->ip();
            $comment = new CommentProduct();
            $comment->insertComment($input['user_id'], $user_image, $name, $email, $id, $input['type'], $input['content'], null, "text", $is_read, $input['is_active']);
            session()->put('success', trans('app.save_success'));
            return redirect()->route('admin.' . $product->type . 's.comments.index', [$id]);
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

}
