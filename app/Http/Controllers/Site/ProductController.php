<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Product;
use App\User;
use App\Model\CategoryProduct;
use App\Model\CartProduct;
use App\Model\Fees;
use App\Model\Page;
use App\Model\Options;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_CommentController;
use App\Http\Controllers\ClassSiteApi\Class_PaymentController;
use Session;

class ProductController extends SiteController {

    public function __construct() {
        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->limit = $this_data['limit'];
        $this->logo_image = $this_data['logo_image'];
        $this->current_id = $this_data['current_id'];
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('product');
            $page_title = $page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 5);
            $type = 'product';
            $categories = CategoryProduct::getData_cateorySelect(0, 'product', 'lang', $lang, 1, 0, 0);
            $products = Product::all_Category_product('product', 1, '', '', $lang, 0, $this->limit, -1, 0);
            $count_product = count($products);
            $active_cat_link = 'all';
            return view('site.products.index', compact('logo_image', 'active_cat_link', 'count_product', 'products', 'categories', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function categorySingle(Request $request, $cat_link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $catgeory = CategoryProduct::where('link', $cat_link)->where('is_active', 1)->first();
            if (isset($catgeory->id)) {
                $lang = 'ar';
                $page = Page::get_typeColum('product');
                $page_title = $page->title;
                $title = $page_title . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 5);
                $type = 'product';
                $categories = CategoryProduct::getData_cateorySelect(0, 'product', 'lang', $lang, 1, 0, 0);
                $products = Product::Category_product($lang, $catgeory, [], 'id', 'DESC', 1, 0, 1);
                $count_product = count($products);
                $active_cat_link = $catgeory->link;
                return view('site.products.index', compact('logo_image', 'active_cat_link', 'count_product', 'products', 'categories', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return redirect()->route('categories.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

    public function productSingle(Request $request, $cat_link, $link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $catgeory = CategoryProduct::where('link', $cat_link)->where('is_active', 1)->first();
            if (isset($catgeory->id)) {
                $data = Product::get_product('link', $link, 'ar', 1);
                if (isset($data->id)) {
                    Product::updateProductViewCount($data->id);
                    $page = Page::get_typeColum('product');
                    $page_title = $page->title;
                    $title = $page_title . " - " . $catgeory->name . " - " . $data->name . " - " . $this->site_title;
                    $logo_image = $this->logo_image;
                    View::share('title', $title);
                    View::share('activ_menu', 5);
                    $type = 'product';
                    $get_comment = new Class_CommentController();
                    $all_comment = $get_comment->get_commentdata($data, 'product');
                    $all_comment['page_title'] = $page_title;
                    $all_comment['catgeory'] = $catgeory;
                    $all_comment['data'] = Product::get_ProductSingle($data, 1);  //data product
                    $all_comment['share_link'] = route('categories.category.products.single', [$all_comment['data']['cat_link'], $all_comment['data']['link']]);
                    $all_comment['share_image'] = $all_comment['data']['image'];
                    $all_comment['title'] = $title; //$all_comment['data']['name'];
                    $all_comment['share_description'] = $all_comment['data']['description'];
                    return view('site.products.single', $all_comment)->with('i', ($request->input('page', 1) - 1) * 5);
                } else {
                    return redirect()->route('categories.category.single', $catgeory->link);
                }
            } else {
                return redirect()->route('categories.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

//*****************************cart product ********************
    public function cartProduct(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            //$page = Page::get_typeColum('product');
            $page_title = 'سلة المشتريات'; // $page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 14);
            $type = 'product';
//                    session()->put('session_product_cart', '');
//                 session()->put('price_product_cart', 0);
            if (!isset(Auth::user()->id)) { // && Auth::user()->id <= 0
                $product_cart = session()->get('session_product_cart');
                $total_price_cart = session()->get('price_product_cart');
                if (empty($product_cart)) {
                    $product_cart = [];
                    $total_price_cart = 0.00;
                }
            } else {
                //get data of cart from table
                $data_cart = CartProduct::getCartProductType('user_id', Auth::user()->id, 'product', 'id', 'DESC', 1, -1);
                $array_data = CartProduct::dataCartProduct($data_cart);
                $product_cart = $array_data['product_cart'];
                $total_price_cart = $array_data['total_price_cart'];
            }
            $count_product_cart = count($product_cart);
            $cart_fees = [];
            if (!empty($product_cart)) {
                $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
                $cart_fees = Fees::dataFees($data_fees, 0, $total_price_cart);
            }
            return view('site.products.cart', compact('product_cart', 'cart_fees', 'total_price_cart', 'count_product_cart', 'logo_image', 'type', 'page_title'));
        } else {
            return redirect()->route('close');
        }
    }

//*****************************checkout & payment product ********************
    public function checkoutProduct(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            if (isset(Auth::user()->id)) {
                $lang = 'ar';
                //$page = Page::get_typeColum('product');
                $page_title = 'سلة المشتريات'; // $page->title;
                $title = $page_title . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 14);
                $type = 'product';
                $get_data = new Class_PaymentController();
                $array_data = $get_data->Payment_product(Auth::user(), 0);
                $array_data['type_button'] = 'product';
                $array_data['match_link '] = '';
                if (isset($array_data['ok_chechout']) && $array_data['ok_chechout'] == 1) {
                    $array_data['shopperResultUrl'] = route('products.payment.callback'); // 'https://hyperpay.docs.oppwa.com/tutorials/integration-guide';      
                    return view('site.payment.product_index', $array_data);
                } else {
                    $array_data = $get_data->Message_failPay($request, 5, 0);
                    return view('site.payment.product_callback', $array_data);
                }
            } else {
                return redirect()->route('login');
            }
        } else {
            return redirect()->route('close');
        }
    }

    public function paymentcallback(Request $request) {
        if (isset(Auth::user()->id)) {
            View::share('title', 'ادفع الان');
            View::share('activ_menu', 3);
            //Ex:http://127.0.0.1:9000/payment/callback?id=671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04&resourcePath=%2Fv1%2Fcheckouts%2F671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04%2Fpayment
            $checkout_id = $_REQUEST['id'];
            $resourcePath = $_REQUEST['resourcePath'];
//            print_r($resourcePath);die;
            $get_data = new Class_PaymentController();
            $array_data = $get_data->Product_paymentCallBack($request, Auth::user(), $checkout_id, $resourcePath, 0);
            $array_data['type_button'] = 'product';
            $array_data['match_link '] = '';
            return view('site.payment.product_callback', $array_data);
        } else {
            return redirect()->route('home');
        }
    }

}
