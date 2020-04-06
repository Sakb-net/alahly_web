<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Options;
use App\User;
use App\Model\Product;
use App\Model\CategoryProduct;
use App\Model\CartProduct;
use App\Model\Fees;
use App\Model\Order;
use DB;
use Session;
use App\Http\Controllers\SiteController;

//use App\Http\Controllers\ClassSiteApi\Class_MasterController;

class AjaxProduct extends SiteController {

    public function __construct() {
        //parent::__construct();
//        $this->middleware('auth');
//        $this->middleware(function ($request, $next) {
//            $this->user = auth()->user();
//            return $next($request);
//        });

        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->limit = $this_data['limit'];
        $this->current_id = $this_data['current_id'];
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

//**************************************page:category/section ******************************************************

    public function get_categoriesProduct(Request $request) {
        if ($request->ajax()) {
            $products = $products_cart = $products_order_active = $current_order_active = [];
            $status = $count_product = $ok_cat = $count_cart = $offset = 0;
            //$price_cart = 0.00;
            $lang = 'ar';
            $limit = 15;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $col_order = 'id';
            $val_order = 'DESC';
            if ($input['val_sort'] == 'price_asc') {
                $col_order = 'price';
                $val_order = 'ASC';
            } elseif ($input['val_sort'] == 'price_desc') {
                $col_order = 'price';
                $val_order = 'DESC';
            } elseif ($input['val_sort'] == 'rate') {
                $col_order = 'rate';
                $val_order = 'DESC';
            }
            $offset = $input['offset'];
            $active_cat_link = $input['link'];
            $state_url = route('categories.category.single', $input['link']);
            if ($input['link'] == 'all') {
                $state_url = route('categories.index');
                $ok_cat = 1;
                $products = Product::all_Category_product('product', 1, '', '', $lang, 0, $limit, -1, 0, $col_order, $val_order);
            } else {
                $category = CategoryProduct::get_categoryRow($input['link'], 'link', 1);
                if (isset($category->id)) {
                    $ok_cat = 1;
                    $products = Product::Category_product($lang, $category, [], $col_order, $val_order, 1, 0, 1);
                }
            }
            if ($ok_cat == 1) {
                $status = 1;
                $count_product = count($products);
                //cart in session
//                $price_cart = $request->session()->get('price_product_cart');
//                if (empty($price_cart)) {
//                    $price_cart = 0.00;
//                }
//                $session_cart = $request->session()->get('session_product_cart');
//                if (empty($session_cart)) {
//                    $session_cart = [];
//                }
//                foreach ($session_cart as $key => $val_sesstion) {
//                    $products_cart[] = $val_sesstion['id'];
//                }
//                $count_cart = count($session_cart);
//
//                $products_order_active = []; // Order::get_orderChairCategory('', $category->id, 1,1,-1);
//                $current_order_active = []; // Order::get_orderChairCategory(Auth::user()->id, $category->id, 1,1, -1);
            }
            $response = view('site.products.products', ['products' => $products, 'limit' => $limit])->render();
            return response()->json(['status' => $status, 'state_url' => $state_url, 'active_cat_link' => $active_cat_link, 'count_product' => $count_product, 'response' => $response]);
//            $response = view('site.products.products', ['products' => $products, 'products_cart' => $products_cart, 'products_order_active' => $products_order_active, 'current_order_active' => $current_order_active])->render();
//            return response()->json(['status' => $status,'count_product'=>$count_product, 'count_cart' => $count_cart, 'price_cart' => $price_cart, 'category' => $category, 'response' => $response]);
        }
    }

    public function sort_cat_Product(Request $request) {
        if ($request->ajax()) {
            $products = $products_cart = $products_order_active = $current_order_active = [];
            $status = $count_product = $ok_cat = $count_cart = $offset = 0;
            //$price_cart = 0.00;
            $lang = 'ar';
            $limit = 15;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $col_order = 'id';
            $val_order = 'DESC';
            if ($input['val_sort'] == 'price_asc') {
                $col_order = 'price';
                $val_order = 'ASC';
            } elseif ($input['val_sort'] == 'price_desc') {
                $col_order = 'price';
                $val_order = 'DESC';
            } elseif ($input['val_sort'] == 'rate') {
                $col_order = 'rate';
                $val_order = 'DESC';
            }
            $offset = $input['offset'];
            $active_cat_link = $input['link'];
            $state_url = route('categories.category.single', $input['link']);
            if ($input['link'] == 'all') {
                $state_url = route('categories.index');
                $ok_cat = 1;
                $products = Product::all_Category_product('product', 1, '', '', $lang, 0, $limit, -1, 0, $col_order, $val_order);
            } else {
                $category = CategoryProduct::get_categoryRow($input['link'], 'link', 1);
                if (isset($category->id)) {
                    $ok_cat = 1;
                    $products = Product::Category_product($lang, $category, [], $col_order, $val_order, 1, 0, 1);
                }
            }
            if ($ok_cat == 1) {
                $status = 1;
                $count_product = count($products);
                //cart in session
//                $price_cart = $request->session()->get('price_product_cart');
//                if (empty($price_cart)) {
//                    $price_cart = 0.00;
//                }
//                $session_cart = $request->session()->get('session_product_cart');
//                if (empty($session_cart)) {
//                    $session_cart = [];
//                }
//                foreach ($session_cart as $key => $val_sesstion) {
//                    $products_cart[] = $val_sesstion['id'];
//                }
//                $count_cart = count($session_cart);
//
//                $products_order_active = []; // Order::get_orderChairCategory('', $category->id, 1,1,-1);
//                $current_order_active = []; // Order::get_orderChairCategory(Auth::user()->id, $category->id, 1,1, -1);
            }
            $response = view('site.products.products', ['products' => $products, 'limit' => $limit])->render();
            return response()->json(['status' => $status, 'state_url' => $state_url, 'active_cat_link' => $active_cat_link, 'count_product' => $count_product, 'response' => $response]);
//            $response = view('site.products.products', ['products' => $products, 'products_cart' => $products_cart, 'products_order_active' => $products_order_active, 'current_order_active' => $current_order_active])->render();
//            return response()->json(['status' => $status,'count_product'=>$count_product, 'count_cart' => $count_cart, 'price_cart' => $price_cart, 'category' => $category, 'response' => $response]);
        }
    }

//******************************
    public function select_weight_fees_Product(Request $request) {
        if ($request->ajax()) {
            $status = $dec_prod['ok_discount'] = 0;
            $dec_prod['price'] = $dec_prod['total_price'] = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != 'fees') {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                } else {
                    $input[$key] = $value;
                }
            }
            $product = Product::get_productType($input['link'], 'product', 1);
            if (isset($product->id)) {
                $status = 1;
                if (!isset($input['fees'])) {
                    $input['fees'] = [];
                } else {
                    $input['fees'] = Product::fees_stripslashes($input['fees']);
                }
                $dec_prod = Product::ValueDec_prod($product, $input['code_weight'], $input['fees']);
            }
            return response()->json(['status' => $status, 'price' => $dec_prod['price'], 'ok_discount' => $dec_prod['ok_discount'], 'total_price' => $dec_prod['total_price']]);
        }
    }

    public function add_cart_productDetails(Request $request) {
        if ($request->ajax()) {
            $category = '';
            $status = 0;
            $cart_fees = [];
            $price_cart = $price_session_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != 'fees') {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                } else {
                    $input[$key] = $value;
                }
            }
            // name, quantity, code_weight,color,name_print,fees
            $product = Product::get_productType($input['link'], 'product', 1);
            if (isset($product->id)) {
                if (!isset($input['fees'])) {
                    $input['fees'] = [];
                } else {
                    $input['fees'] = Product::fees_stripslashes($input['fees']);
                }
                if (!isset($input['quantity']) || $input['quantity'] <= 0) {
                    $quantity = 1;
                } else {
                    $quantity = $input['quantity'];
                }
                $status = 1;
                $category = $product->categories[0];
                if (empty($input['code_weight']) && empty($input['fees'])) {
                    $total_pric = Product::totalPrice($product->price, $product->discount);
                    $price = $product->price;
                    $discount = $product->discount;
                    $weight = '';
                    $total_price_fees = 0.00;
                } else {
                    $dec_prod = Product::ValueDec_prod($product, $input['code_weight'], $input['fees']);
                    $price = $dec_prod['price'];
                    $discount = $dec_prod['discount'];
                    $total_pric = $dec_prod['total_price'];
                    $weight = $dec_prod['weight'];
                    $total_price_fees = $dec_prod['total_price_fees'];
                }
                $content_array = array('weight' => $weight, 'color' => $input['color'],
                    'fees' => $input['fees'],'total_price_fees'=>$total_price_fees, 'name_print' => $input['name_print']);
                $description = json_encode($content_array, true);
                $session_cart_new = ['cat_link' => $category->link, 'cat_name' => $category->name, 'id' => $product->id, 'link' => $product->link, 'image' => $product->image, 'quantity' => $quantity, 'name' => $product->name, 'total_price' => $total_pric, 'price' => $price, 'discount' => $discount, 'description' => $description];
                if (!isset(Auth::user()->id)) { // && Auth::user()->id <= 0
                    $session_cart = $request->session()->get('session_product_cart');
                    if (empty($session_cart)) {
                        $session_cart = [];
                    }
                    $add_session_cart = [];
                    foreach ($session_cart as $key_session => $val_session) {
                        if ($val_session['id'] != $product->id) {
                            $add_session_cart[] = $val_session;
                            $price_session_cart += $val_session['total_price'];
                        } else {
                            // $session_cart_new['quantity'] += $val_session['quantity'];
                        }
                    }
                    $add_session_cart[] = $session_cart_new;
                    $price_cart = ($session_cart_new['total_price'] * $session_cart_new['quantity']) + $price_session_cart;

                    $request->session()->put('session_product_cart', $add_session_cart);
                    $request->session()->put('price_product_cart', $price_cart);
                } else {
                    //save in table cart product
                    CartProduct::InsertColums(Auth::user()->id, $session_cart_new, 'product', 1);
                    //get data of cart from table
                    $data_cart = CartProduct::getCartProductType('user_id', Auth::user()->id, 'product', 'id', 'DESC', 1, -1);
                    $array_data = CartProduct::dataCartProduct($data_cart);
                    $add_session_cart = $array_data['product_cart'];
                    $price_cart = $array_data['total_price_cart'];
                }
                $count_cart = count($add_session_cart);
                $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
                $cart_fees = Fees::dataFees($data_fees, 0, $price_cart);
            }
            $response = view('site.layouts.menu_cart', ['cart_fees' => $cart_fees,'total_price_fees'=>$total_price_fees, 'product_cart' => $add_session_cart, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart])->render();
            return response()->json(['status' => $status, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart, 'response' => $response]); //, 'product' => $product, 'category' => $category
        }
    }

    public function add_cart_product(Request $request) {
        if ($request->ajax()) {
            $category = '';
            $quantity = 1;
            $status = 0;
            $cart_fees = [];
            $price_cart = $price_session_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != 'fees') {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                } else {
                    $input[$key] = $value;
                }
            }
            $product = Product::get_productType($input['link'], 'product', 1);
            if (isset($product->id)) {
                $status = 1;
                if (!isset($input['code_weight'])) {
                    $input['code_weight'] = '';
                }
                if (!isset($input['fees'])) {
                    $input['fees'] = [];
                } else {
                    $input['fees'] = Product::fees_stripslashes($input['fees']);
                }
                $category = $product->categories[0];
                if (empty($input['code_weight']) && empty($input['fees'])) {
                    $total_pric = Product::totalPrice($product->price, $product->discount);
                    $price = $product->price;
                    $discount = $product->discount;
                    $weight = '';
                    $total_price_fees=0.00;
                } else {
                    $dec_prod = Product::ValueDec_prod($product, $input['code_weight'], $input['fees']);
                    $price = $dec_prod['price'];
                    $discount = $dec_prod['discount'];
                    $total_pric = $dec_prod['total_price'];
                    $weight = $dec_prod['weight'];
                    $total_price_fees = $dec_prod['total_price_fees'];
                }
                $content_array = array('weight' => $weight, 'color' => '',
                    'fees' => $input['fees'],'total_price_fees'=>$total_price_fees, 'name_print' => '');
                $description = json_encode($content_array, true);
                $session_cart_new = ['cat_link' => $category->link, 'cat_name' => $category->name, 'id' => $product->id, 'link' => $product->link, 'image' => $product->image, 'quantity' => $quantity, 'name' => $product->name, 'total_price' => $total_pric, 'price' => $price, 'discount' => $discount, 'description' => $description];
                if (!isset(Auth::user()->id)) { // && Auth::user()->id <= 0
                    $session_cart = $request->session()->get('session_product_cart');
                    if (empty($session_cart)) {
                        $session_cart = [];
                    }
                    $add_session_cart = [];
                    foreach ($session_cart as $key_session => $val_session) {
                        if ($val_session['id'] != $product->id) {
                            $add_session_cart[] = $val_session;
                            $price_session_cart += $val_session['total_price'];
                        } else {
                            $session_cart_new['quantity'] += $val_session['quantity'];
                        }
                    }
                    $add_session_cart[] = $session_cart_new;
                    $price_cart = ($session_cart_new['total_price'] * $session_cart_new['quantity']) + $price_session_cart;

                    $request->session()->put('session_product_cart', $add_session_cart);
                    $request->session()->put('price_product_cart', $price_cart);
                } else {
                    //save in table cart product
                    CartProduct::InsertColums(Auth::user()->id, $session_cart_new, 'product');
                    //get data of cart from table
                    $data_cart = CartProduct::getCartProductType('user_id', Auth::user()->id, 'product', 'id', 'DESC', 1, -1);
                    $array_data = CartProduct::dataCartProduct($data_cart);
                    $add_session_cart = $array_data['product_cart'];
                    $price_cart = $array_data['total_price_cart'];
                }
                $count_cart = count($add_session_cart);
                $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
                $cart_fees = Fees::dataFees($data_fees, 0, $price_cart);
            }
            $response = view('site.layouts.menu_cart', ['cart_fees' => $cart_fees,'total_price_fees'=>$total_price_fees, 'product_cart' => $add_session_cart, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart])->render();
            return response()->json(['status' => $status, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart, 'response' => $response]); //, 'product' => $product, 'category' => $category
        }
    }

    public function changnum_cartProduct(Request $request) {
        if ($request->ajax()) {
            $category = '';
            $cart_fees = [];
            $status = $price_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $product = Product::get_productType($input['link'], 'product', 1);
            if (isset($product->id)) {
                $status = 1;
                $category = $product->categories[0];
                if (!isset(Auth::user()->id)) { // && Auth::user()->id <= 0
                    $session_cart = $request->session()->get('session_product_cart');
                    if (empty($session_cart)) {
                        $session_cart = [];
                    }
                    $add_session_cart = [];
                    foreach ($session_cart as $key_cart => $val_cart) {
                        if ($val_cart['id'] != $product->id) {
                            $add_session_cart [] = $val_cart;
                            $price_cart += $val_cart['total_price'] * $val_cart['quantity'];
                        } else {
                            if ($input['quantity'] > 0) {
                                //change quantity and add in session
                                $val_cart['quantity'] = $input['quantity'];
                                $add_session_cart [] = $val_cart;
                                $price_cart += $val_cart['total_price'] * $input['quantity'];
                            }
                        }
                    }
                    $request->session()->put('session_product_cart', $add_session_cart);
                    $request->session()->put('price_product_cart', $price_cart);
                } else {
                    //delete or change quantity for this product from table CartProduct
                    if ($input['quantity'] > 0) {
                        //change in table cart product
                        $input['id'] = $product->id;
                        CartProduct::InsertColums(Auth::user()->id, $input, 'product', 1);
                    } else {
                        CartProduct::deleteCartProduct(Auth::user()->id, $product->id);
                    }
                    //get data of cart from table
                    $data_cart = CartProduct::getCartProductType('user_id', Auth::user()->id, 'product', 'id', 'DESC', 1, -1);
                    $array_data = CartProduct::dataCartProduct($data_cart);
                    $add_session_cart = $array_data['product_cart'];
                    $price_cart = $array_data['total_price_cart'];
                }
                $count_cart = count($add_session_cart);
                $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
                $cart_fees = Fees::dataFees($data_fees, 0, $price_cart);
            }
            $response = view('site.products.cart_draw', ['product_cart' => $add_session_cart, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart])->render();
            return response()->json(['status' => $status, 'product_cart' => $add_session_cart, 'cart_fees' => $cart_fees, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart, 'response' => $response]); //, 'product' => $product, 'category' => $category
        }
    }

    public function remove_cartProduct(Request $request) {
        if ($request->ajax()) {
            $category = '';
            $cart_fees = [];
            $status = $price_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $product = Product::get_productType($input['link'], 'product', 1);
            if (isset($product->id)) {
                $status = 1;
                $category = $product->categories[0];
                if (!isset(Auth::user()->id)) { // && Auth::user()->id <= 0
                    $session_cart = $request->session()->get('session_product_cart');
                    if (empty($session_cart)) {
                        $session_cart = [];
                    }
                    $add_session_cart = [];
                    foreach ($session_cart as $key_cart => $val_cart) {
                        if ($val_cart['id'] != $product->id) {
                            $add_session_cart [] = $val_cart;
                            $price_cart += $val_cart['total_price'] * $val_cart['quantity'];
                        }
                    }
                    $request->session()->put('session_product_cart', $add_session_cart);
                    $request->session()->put('price_product_cart', $price_cart);
                } else {
                    //delete this product from table CartProduct
                    CartProduct::deleteCartProduct(Auth::user()->id, $product->id);
                    //get data of cart from table
                    $data_cart = CartProduct::getCartProductType('user_id', Auth::user()->id, 'product', 'id', 'DESC', 1, -1);
                    $array_data = CartProduct::dataCartProduct($data_cart);
                    $add_session_cart = $array_data['product_cart'];
                    $price_cart = $array_data['total_price_cart'];
                }
                $count_cart = count($add_session_cart);
                $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
                $cart_fees = Fees::dataFees($data_fees, 0, $price_cart);
            }
            $response = view('site.products.cart_draw', ['product_cart' => $add_session_cart, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart])->render();
            return response()->json(['status' => $status, 'product_cart' => $add_session_cart, 'cart_fees' => $cart_fees, 'count_product_cart' => $count_cart, 'total_price_cart' => $price_cart, 'response' => $response]); //, 'product' => $product, 'category' => $category
        }
    }

}

//return response()->json