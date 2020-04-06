<?php

namespace App\Http\Controllers\Api\V1;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\API_Controller;
use App\User;
use App\Model\CategoryProduct;
use App\Model\Product;
use App\Model\CartProduct;
use App\Model\Fees;
use App\Http\Controllers\ClassSiteApi\Class_PaymentController;

class ProductController extends API_Controller {
    /**
     * get data product_categories  
     * get method
     * url : http://localhost:8000/api/v1/product_categories
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product_categories",
     *   tags={"product"},
     *   operationId="product_categories",
     *   summary="get categories of products",
     * @SWG\Parameter(
     *   name="access-token",
     *     in="header",
     *     type="string"
     *   ),
     * @SWG\Parameter(
     *    name="num_page",
     *    in= "formData",
     *    type="number",
     *    description=" number of page start from zero ( 0 )",
     *  ),
     *  @SWG\Parameter(
     *    name="limit",
     *    in= "formData",
     *    type="number",
     *    description=" limit is number product_categories will send all data with default ( 0 )",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function product_categories(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $data_user = User::user_access_token($access_token, 1);
        $user_id = 0;
        if (isset($data_user->id)) {
            $user_id = $data_user->id;
        }
        $input = $request->all();
        $num_page = isset($input['num_page']) ? $input['num_page'] : 0;
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $offset = $num_page * $limit;
        $categories = CategoryProduct::getData_cateorySelect(0, 'product', 'lang', $lang, 1, 0, 1, $limit, $offset);
        $count_cart = CartProduct::getCartProductTypeCount('user_id', $user_id, 'product', 'id', 'DESC', 1, -1);
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['count_cart'] = $count_cart;
        $response['data'] = $categories;
        return response()->json($response, 200);
    }

    /**
     * get data product_category  
     * get method
     * url : http://localhost:8000/api/v1/product_category
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product_category",
     *   tags={"product"},
     *   operationId="product_category",
     *   summary="get product in category by category link",
     * @SWG\Parameter(
     *    name="cat_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of product_category",
     *  ),
     * @SWG\Parameter(
     *    name="val_sort",
     *    in= "formData",
     *    type="string",
     *    description="default is sort by ID (price_asc  - price_desc - rate)",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default is ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function product_category(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $cat_link = isset($input['cat_link']) ? $input['cat_link'] : '';
        $val_sort = isset($input['val_sort']) ? $input['val_sort'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($cat_link == "") {
            $fields['cat_link'] = 'cat_link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user_id = 0;
        if (!empty($access_token)) {
            $data_user = User::user_access_token($access_token, 1);
            if (isset($data_user->id)) {
                $user_id = $data_user->id;
            }
        }
        $catgeory = CategoryProduct::where('link', $cat_link)->where('is_active', 1)->first();
        if (isset($catgeory->id)) {
            $data_category['link'] = $catgeory->link;
            $data_category['name'] = $catgeory->name;
            $data_category['content'] = $catgeory->content;
            $data_category['image'] = $catgeory->icon_image;
            $col_order = 'id';
            $val_order = 'DESC';
            if ($val_sort == 'price_asc') {
                $col_order = 'price';
                $val_order = 'ASC';
            } elseif ($val_sort == 'price_desc') {
                $col_order = 'price';
                $val_order = 'DESC';
            } elseif ($val_sort == 'rate') {
                $col_order = 'rate';
                $val_order = 'DESC';
            }
            $data_category['products'] = Product::Category_product($lang, $catgeory, [], $col_order, $val_order, 1, 0, 1);
            $count_cart = CartProduct::getCartProductTypeCount('user_id', $user_id, 'product', 'id', 'DESC', 1, -1);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['count_products'] = count($data_category['products']);
            $response['count_cart'] = $count_cart;
            $response['data'] = $data_category;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

    /**
     * get data products , if found sent access_token
     * post method
     * url : http://localhost:8000/api/v1/products
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/products",
     *   tags={"product"},
     *   operationId="products",
     *   summary="get all products",
     *  @SWG\Parameter(
     *    name="num_page",
     *    in= "formData",
     *    type="number",
     *    description=" number of page start from zero ( 0 )",
     *  ),
     *  @SWG\Parameter(
     *    name="limit",
     *    in= "formData",
     *    type="number",
     *    description=" limit is number products will send in each time default ( 12 )",
     *  ),
     * @SWG\Parameter(
     *    name="val_sort",
     *    in= "formData",
     *    type="string",
     *    description="default is sort by ID (price_asc  - price_desc - rate)",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function products(Request $request) {
        $input = $request->all();
        $num_page = isset($input['num_page']) ? $input['num_page'] : 0;
        $limit = isset($input['limit']) ? $input['limit'] : 12;
        $val_sort = isset($input['val_sort']) ? $input['val_sort'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $offset = $num_page * $limit;
        $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
        $response['Message'] = API_Controller::SUCCESS_MESSAGE;
        $col_order = 'id';
        $val_order = 'DESC';
        if ($val_sort == 'price_asc') {
            $col_order = 'price';
            $val_order = 'ASC';
        } elseif ($val_sort == 'price_desc') {
            $col_order = 'price';
            $val_order = 'DESC';
        } elseif ($val_sort == 'rate') {
            $col_order = 'rate';
            $val_order = 'DESC';
        }
        $all_products = Product::get_ProductActive('product', 1, '', '', $lang, 0, $limit, $offset, $col_order, $val_order);
        $products = Product::dataProduct($all_products, 1);
        $response['data'] = $products;
        return response()->json($response, 200);
    }

    /**
     * Show single page of one products   
     * get method
     * url : http://localhost:8000/api/v1/products/single
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *  path="/products/single",
     *   tags={"product"},
     *   operationId="productsSingle",
     *   summary="get single product by product link",
     * @SWG\Parameter(
     *    name="products_link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *    description="link of products",
     *  ),
     * @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar - en)",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function productsSingle(Request $request) {
        $input = $request->all();
        $products_link = isset($input['products_link']) ? $input['products_link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($products_link == "") {
            $fields['products_link'] = 'products_link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $product = Product::get_product('link', $products_link, $lang, 1);
        if (isset($product->id)) {
            Product::updateProductViewCount($product->id);
            $data_products = Product::get_ProductSingle($product, 1);
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data_products;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
            return response()->json($response, 400);
        }
    }

//***********************cart **********************************
    /**
     * get data product_cart
     * post method
     * url : http://localhost:8000/api/v1/product_cart
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product_cart",
     *   tags={"product"},
     *   operationId="product_cart",
     *   summary="get all products in cart",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),  
     *  @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
     *    type="string",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *    
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function product_cart(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user = User::user_access_token($access_token, 1);
        if (isset($user->id)) {
            $data_cart = CartProduct::getCartProductType('user_id', $user->id, 'product', 'id', 'DESC', 1, -1);
            $data = CartProduct::dataCartProduct($data_cart, 1);
            $cart_fees = [];
            if (!empty($data['product_cart'])) {
                $data_fees = Fees::feesSelectArrayCol('product', 'id', [1, 2], 1, 0);
                $cart_fees = Fees::dataFees($data_fees);
            }
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $data;
            $response['cart_fees'] = $cart_fees;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * add or update data in addupdate_cart
     * post method
     * url : http://localhost:8000/api/v1/product/addupdate_cart
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product/addupdate_cart",
     *   tags={"product"},
     *   operationId="product_addupdate_cart",
     *   summary="add or update product in cart",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *  @SWG\Parameter(
     *    name="quantity",
     *    in= "formData",
     *    required=true,
     *    type="number",
     *  ),
     *  @SWG\Parameter(
     *    name="weight",
     *    in= "formData",
     *    type="string",
     *  ),
     *  @SWG\Parameter(
     *    name="fees[]",
     *    in= "query",
     *    required=true,
     *    type="string",
     *    collectionFormat="multi",
     *    description="[link_1,link_2,link_3]",
     *  ),
     *  @SWG\Parameter(
     *    name="color",
     *    in= "formData",
     *    type="string",
     *  ),
     *  @SWG\Parameter(
     *    name="name_print",
     *    in= "formData",
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar or en )",
     *  ), 
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function product_addupdate_cart(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $link = isset($input['link']) ? $input['link'] : '';
        $quantity = isset($input['quantity']) ? $input['quantity'] : 1;
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $weight = isset($input['weight']) ? $input['weight'] : '';
        $color = isset($input['color']) ? $input['color'] : '';
        $name_print = isset($input['name_print']) ? $input['name_print'] : '';
        $fees = isset($input['fees']) ? $input['fees'] : []; //EX: link_1,link_2,link_3
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($link == "") {
            $fields['link'] = 'link';
        }
        if (!empty($fees)) {
            if (!is_array($fees)) {
                $fields['fees'] = 'Not Array fees';
            }
        }else{
            $fees=[];
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user = User::user_access_token($access_token, 1);
        if (isset($user->id)) {
            $product = Product::get_productType($link, 'product', 1);
            if (isset($product->id)) {
                //delete or change quantity for this product from table CartProduct
                if ($quantity > 0) {
                    //change in table cart product
                    $input['quantity'] = $quantity;
                    $input['id'] = $product->id;
                    $input['product_id'] = $product->id;
                    $input['price'] = $product->price;
                    $input['discount'] = $product->discount;
                    $content_array = array('weight' => $weight, 'fees' => $fees,
                        'color' => $color, 'name_print' => $name_print);
                    $input['description'] = json_encode($content_array, true);
                    CartProduct::InsertColums($user->id, $input, 'product', 1);
                } else {
                    CartProduct::deleteCartProduct($user->id, $product->id);
                }
                //get data of cart from table
                $data_cart = CartProduct::getCartProductType('user_id', $user->id, 'product', 'id', 'DESC', 1, -1);
                $data = CartProduct::dataCartProduct($data_cart, 1);
                $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                $response['data'] = $data;
                return response()->json($response, 200);
            } else {
                $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
                return response()->json($response, 400);
            }
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * delete data in delete_cart
     * post method
     * url : http://localhost:8000/api/v1/product/delete_cart
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product/delete_cart",
     *   tags={"product"},
     *   operationId="product_delete_cart",
     *   summary="delete product from cart",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="link",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),
     *   @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    type="string",
     *    description="default ar (ar or en )",
     *  ), 
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function product_delete_cart(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $link = isset($input['link']) ? $input['link'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';

        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($link == "") {
            $fields['link'] = 'link';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user = User::user_access_token($access_token, 1);
        if (isset($user->id)) {
            $product = Product::get_productType($link, 'product', 1);
            if (isset($product->id)) {
                //delete this product from table CartProduct
                CartProduct::deleteCartProduct($user->id, $product->id);
                //get data of cart from table
                $data_cart = CartProduct::getCartProductType('user_id', $user->id, 'product', 'id', 'DESC', 1, -1);
                $data = CartProduct::dataCartProduct($data_cart, 1);
                $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
                $response['data'] = $data;
                return response()->json($response, 200);
            } else {
                $response = API_Controller::MessageData('NO_DATA_FOUND', $lang);
                return response()->json($response, 400);
            }
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

//*************************** payment Product*********************
    /**
     * get data checkoutProduct
     * post method
     * url : http://localhost:8000/api/v1/product/checkout
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product/checkout",
     *   tags={"product"},
     *   operationId="checkoutProduct",
     *   summary="checkout for all products that found in cart",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),  
     *  @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
     *    type="string",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *    
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function checkoutProduct(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user = User::user_access_token($access_token, 1);
        if (isset($user->id)) {
            $get_data = new Class_PaymentController();
            $array_data = $get_data->Payment_product($user, 1);
            $array_data['shopperResultUrl'] = '';
            if (isset($array_data['ok_chechout']) && $array_data['ok_chechout'] == 1) {
                $array_data['shopperResultUrl'] = 'http://' . $_SERVER['SERVER_NAME'] . '/v1/product/paymentcallback'; // 'https://hyperpay.docs.oppwa.com/tutorials/integration-guide';      
            }
            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $array_data;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

    /**
     * get data product resultcallback
     * post method
     * url : http://localhost:8000/api/v1/product/resultcallback
     *
     * @return response Json
     */

    /**
     * @SWG\Post(
     *   path="/product/resultcallback",
     *   tags={"product"},
     *   operationId="resultcallback",
     *   summary="result callback after return from payment",
     *   @SWG\Parameter(
     *    name="access-token",
     *    in= "header",
     *    required=true,
     *    type="string",
     *  ),  
     *   @SWG\Parameter(
     *    name="checkout_id",
     *    in= "formData",
     *    required=true,
     *    type="string",
     *  ),  
     *  @SWG\Parameter(
     *    name="lang",
     *    in= "formData",
     *    description="default = ar (ar, en)" ,
     *    type="string",
     *  ),
     *   @SWG\Response(
     *    response=200,
     *    description="success",
     *    
     *   ),
     *   @SWG\Response(
     *    response=400,
     *    description="error",
     *  )
     * )
     */
    public function resultcallback(Request $request) {
        $access_token = isset(getallheaders()['Access-Token']) ? getallheaders()['Access-Token'] : '';
        if (empty($access_token)) {
            $access_token = isset(getallheaders()['access-token']) ? getallheaders()['access-token'] : '';
        }
        $input = $request->all();
        $checkout_id = isset($input['checkout_id']) ? $input['checkout_id'] : '';
        $resourcePath = isset($input['resourcePath']) ? $input['resourcePath'] : '';
        $lang = isset($input['lang']) ? $input['lang'] : 'ar';
        $response = [];
        $fields = [];
        if ($access_token == "") {
            $fields['access_token'] = 'access-token';
        }
        if ($checkout_id == "") {
            $fields['checkout_id'] = 'checkout_id';
        }
//        if ($resourcePath == "") {
//            $fields['resourcePath'] = 'resourcePath';
//        }
        if (!empty($fields)) {
            $response = API_Controller::MessageData('MISSING_FIELD', $lang);
            $response['data'] = $fields;
            return response()->json($response, 400);
        }
        $user = User::user_access_token($access_token, 1);
        if (isset($user->id)) {
            //Ex:http://127.0.0.1:9000/payment/callback?id=671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04&resourcePath=%2Fv1%2Fcheckouts%2F671ABA08356B3AF4B4EBEC65842BEB31.uat01-vm-tx04%2Fpayment
//            $checkout_id = $_REQUEST['id'];
//            $resourcePath = $_REQUEST['resourcePath'];

            $get_data = new Class_PaymentController();
            $array_data = $get_data->Product_paymentCallBack([], $user, $checkout_id, $resourcePath, 1);

            $response = API_Controller::MessageData('SUCCESS_MESSAGE', $lang);
            $response['data'] = $array_data;
            return response()->json($response, 200);
        } else {
            $response = API_Controller::MessageData('USER_NOT_Found', $lang);
            return response()->json($response, 401);
        }
    }

}
