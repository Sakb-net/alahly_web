<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Order;
use App\Model\Post;
use App\Model\Video;
use App\Model\Category;
//use App\Model\Section;
use App\Model\Action;
use App\Model\Taggable;
use App\Model\Search;
use App\Model\UserSearch;
use App\Model\Language;
use App\Model\Tag;
use App\Model\Options;
use App\Http\Controllers\SiteController;

class Class_MasterController extends SiteController {

    public function __construct() {
        $data_site = Options::Site_Option();
        $this->site_open = $data_site['site_open'];
        $this->lang = $data_site['lang'];
        $this->site_title = $data_site['site_title'];
        $this->site_url = $data_site['site_url'];
        $this->current_id =0;
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

    function DrawMaster($type = 'section', $parent_id = 0, $api = 0) {
        $data = Category::cateorySelect($parent_id, $type, '', '', 1, 0, 'id', 'ASC'); //where('type', 'section')->where('parent_id', 0)->orderBy('id', 'ASC')->get(); //paginate($this->limit);
        return $data;
    }

    function getSectionSeat($link, $api = 0, $current_id = 0) {
        if ($api == 0) {
            $current_id = $this->current_id;
        }
        $posts = $current_order_active = $chairs_order_active = [];
        $category = Category::get_categoryRow($link, 'link', 1);
        $status = 0;
        if (isset($category->id)) {
            $status = 2;
            if (in_array($category->type_state, ['normal', 'best', 'special'])) { //,complete,not_valid
                $status = 1;
                 $all_posts= Post::get_postCageorty($category->link, 1); 
                $posts = Post::get_postCageortyRow($all_posts, $api);
                if ($api == 0) {
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
                }
                $chairs_order_active = Order::get_orderChairCategory('', $category->id, 1, 1, -1);
                $current_order_active = Order::get_orderChairCategory($current_id, $category->id, 1, 1, -1);
            }
            return array('status' => $status, 'current_order_active' => $current_order_active, 'seats' => $posts, 'seat_order_active' => $chairs_order_active);
        } else {
            return array('status' => $status);
        }
    }

    function DrawSectionSeat($all_data, $api = 0, $current_id = 0) {
        if ($api == 0) {
            $current_id = $this->current_id;
        }
        $array_data=[];
        if ($all_data['status'] == 1) {
            //$all_data= array('status'=>$status,'current_order_active'=>$current_order_active,'seats' => $posts,'seat_order_active'=>$chairs_order_active);
            $posts = $all_data['seats'];
            $current_order_active = $all_data['current_order_active'];
            $chairs_order_active = $all_data['seat_order_active'];
            for ($i = 100; $i > 0; $i--) {
                if (isset($posts[$i]['row']) && $posts[$i]['row'] == $i) {
                    if (in_array($posts[$i]['id'], $current_order_active)) {
                        $val_data['buy'] = 'owner';
                    } elseif (in_array($posts[$i]['id'], $chairs_order_active)) {
                        $val_data['buy'] = 'buy';
                    } else {
                        $val_data['buy'] = 'not_buy';
                    }
                    $val_data['draw'] = 1;
                    $val_data['link'] = $posts[$i]['link'];
                    $val_data['name'] = $posts[$i]['name'];
                    $val_data['row'] = $posts[$i]['row'];
                    $val_data['discount'] = $posts[$i]['discount'];
                    $val_data['price'] = Post::totalPrice($posts[$i]['price'], $posts[$i]['discount']);
                } else {
                    $val_data['draw'] = 0;
                    $val_data['buy'] = '';
                    $val_data['link'] = '';
                    $val_data['name'] = '';
                    $val_data['row'] = '';
                    $val_data['discount'] = '0';
                    $val_data['price'] = '0.00 ريال';
                }
                $val_data['colum'] = $i;
                $array_data[]=$val_data;
            }
        }
        return $array_data;
    }

}
