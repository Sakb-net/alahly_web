<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Options;
use App\User;
use App\Model\Post;
use App\Model\Category;
use App\Model\Match;
use App\Model\Order;
use DB;
use Session;
use App\Http\Controllers\SiteController;

//use App\Http\Controllers\ClassSiteApi\Class_MasterController;

class AjaxTicket extends SiteController {

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

    public function get_section_modal(Request $request) {
        if ($request->ajax() && isset(Auth::user()->id)) {
            $posts = $match = $chairs_cart = $chairs_order_active = $current_order_active = [];
            $status = $count_cart = 0;
            $price_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $category = Category::get_categoryRow($input['link'], 'link', 1);
            if (isset($category->id)) {
                $match = Match::get_matchLink('link', $input['match_link'], 1);
                if (isset($match->id)) {
                    $match = Match::get_MatchSingle($match);
                    $status = 2;
                    if (in_array($category->type_state, ['normal', 'best', 'special'])) { //,complete,not_valid
                        $status = 1;
                        $all_posts = Post::get_postCageorty($category->link, 1);
                        $posts = Post::get_postCageortyRow($all_posts, 0);
                        //cart in session
                        $price_cart = $request->session()->get('price_cart');
                        if (empty($price_cart)) {
                            $price_cart = 0.00;
                        }
                        $session_cart = $request->session()->get('session_cart');
                        if (empty($session_cart)) {
                            $session_cart = [];
                        }
                        foreach ($session_cart as $key => $val_sesstion) {
                            $chairs_cart[] = $val_sesstion['id'];
                        }
                        $count_cart = count($session_cart);

                        $chairs_order_active = Order::get_orderChairCategoryMatch('', $category->id, $match['id'], 1, 1, -1);
                        $current_order_active = Order::get_orderChairCategoryMatch(Auth::user()->id, $category->id, $match['id'], 1, 1, -1);
                    }
                }
            }
            $response = view('site.tickets.chair', ['posts' => $posts, 'match' => $match, 'chairs_cart' => $chairs_cart, 'chairs_order_active' => $chairs_order_active, 'current_order_active' => $current_order_active])->render();
            return response()->json(['status' => $status, 'count_cart' => $count_cart, 'price_cart' => $price_cart, 'category' => $category, 'response' => $response]);
        }
    }

    public function tzaker_chair(Request $request) {
        if ($request->ajax()) {
            $category = '';
            $match=[];
            $status = $price_cart = $price_session_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $post = Post::get_postType($input['link'], 'chair', 1);
            if (isset($post->id)) {
                $match = Match::get_matchLink('link', $input['match_link'], 1);
                if (isset($match->id)) {
                    $match = Match::get_MatchSingle($match);
                    $status = 1;
                    $category = $post->categories[0];
                    $session_cart_new = ['match_id'=>$match['id'],'match_name'=>$match['name'],'cat_link' => $category->link, 'cat_name' => $category->name, 'id' => $post->id, 'link' => $post->link, 'row' => $post->row, 'name' => $post->name, 'price' => $post->price, 'discount' => $post->discount];
                    $session_cart = $request->session()->get('session_cart');
                    if (empty($session_cart)) {
                        $session_cart = [];
                    }
                    $add_session_cart = [];
                    foreach ($session_cart as $key_session => $val_session) {
                        if ($val_session['id'] != $post->id) {
                            $add_session_cart[] = $val_session;
                            $price_session_cart += Post::totalPrice($val_session['price'], $val_session['discount']);
                        }
                    }
                    $add_session_cart[] = $session_cart_new;
                    $price_cart = Post::totalPrice($post->price, $post->discount);
                    $price_cart = $price_cart + $price_session_cart;

                    $count_cart = count($add_session_cart);
                    $request->session()->put('session_cart', $add_session_cart);
                    $request->session()->put('price_cart', $price_cart);
                }
            }
            return response()->json(['status' => $status,'match'=>$match, 'count_cart' => $count_cart, 'price_cart' => $price_cart, 'post' => $post, 'category' => $category]); //, 'response' => $response
        }
    }

    public function remove_cart_chair(Request $request) {
        if ($request->ajax()) {
            $category = '';
            $status = $price_cart = 0.00;
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $post = Post::get_postType($input['link'], 'chair', 1);
            if (isset($post->id)) {
                $status = 1;
                $category = $post->categories[0];
                $session_cart = $request->session()->get('session_cart');
                if (empty($session_cart)) {
                    $session_cart = [];
                }
                $session_cart_new = [];
                foreach ($session_cart as $key_cart => $val_cart) {
                    if ($val_cart['id'] != $post->id) {
                        $session_cart_new [] = $val_cart;
                        $final_price = Post::totalPrice($val_cart['price'], $val_cart['discount']);
                        $price_cart += $final_price;
                    }
                }

                $count_cart = count($session_cart_new);
                $request->session()->put('session_cart', $session_cart_new);
                $request->session()->put('price_cart', $price_cart);
            }
            $response = view('site.profile.body_cart', ['carts' => $session_cart_new, 'count_cart' => $count_cart])->render();
            return response()->json(['status' => $status, 'count_cart' => $count_cart, 'price_cart' => $price_cart, 'category' => $category, 'response' => $response]);
        }
    }

}

//return response()->json