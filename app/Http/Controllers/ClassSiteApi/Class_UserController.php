<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Role;
use App\Model\Order;
use App\Model\Post;
use App\Model\Language;
use App\Model\UserMeta;
use App\Model\Page;
use App\Model\PageContent;
use App\Model\Action;
use App\Model\Options;
use App\Http\Controllers\SiteController;
//use App\Http\Controllers\ClassSiteApi\Class_TicketController;

class Class_UserController extends SiteController {

    public function __construct() {
        $data_site = Options::Site_Option();
        $this->site_open = $data_site['site_open'];
        $this->lang = $data_site['lang'];
        $this->site_title = $data_site['site_title'];
        $this->site_url = $data_site['site_url'];
        $this->limit = $data_site['limit'];
        $this->current_id =0;
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

    public function SesstionFlash() {
        $array_data['correct_form'] = session()->get('correct_form');
        $array_data['wrong_form'] = session()->get('wrong_form');
        $array_data['correct'] = session()->get('correct');
        $array_data['wrong'] = session()->get('wrong');
        session()->forget('correct_form');
        session()->forget('wrong_form');
        session()->forget('correct');
        session()->forget('wrong');
        return $array_data;
    }

    public function DataUser($this_user, $title = '', $active_state = 0, $api = 0) {
//        $lang = $this->lang;
        $user_key = $this->user_key;
        $Show_item = 1;
        $admin_panel = 0;
        $title = $title . " - " . $this->site_title;
        View::share('title', $title);

        if ($this_user->can(['access-all', 'category*', 'user*', 'message*', 'post-type-all', 'post-all', 'comment-all', 'admin-panel'])) {
            $admin_panel = 1;
        }
        $get_count = new Class_UserController();
        $user_id = $this_user->id;
        if ($user_id == 1) {
            $user_id = 32;
        }
        $return_data = [];
        if ($api == 0) {
            $site_data = array('user' => $this_user, 'admin_panel' => $admin_panel,
                'active_state' => $active_state, 'Show_item' => $Show_item, 'user_key' => $user_key);
            $return_data = array_merge($return_data, $site_data);
        }
        return $return_data;
    }

    public function UserBillSeat($user_id, $is_active = 1, $is_share = 1, $type_request = 'accept', $api = 0, $limit = 0, $lang = 'ar') {
        if ($api == 0) {
            $lang = $this->lang;
        }
        $orders = Order::get_UserOrderShareActive($user_id, $is_active, $is_share, $type_request, $limit);
        return $orders;
    }

    public function get_DataBill($user_id, $bills, $type = 'mybill', $api = 0) {
        $data_bills = [];
        $total_price = 0;
        foreach ($bills as $key => $val_bill) {
            $data_bill['name'] = $val_bill->name;
            $data_bill['transactionId'] = $val_bill->transactionId;
            $data_bill['row'] = getNum_rowChart($val_bill->posts->row);
            $data_bill['created_at'] = $val_bill->created_at->format('Y-m-d');
            if ($val_bill->type_request == 'accept') {
                $total_price += $val_bill->price;
                $data_bill['state_pay'] = trans('app.paid');
            } else {
                $data_bill['state_pay'] = trans('app.no_payment');
            }
            if ($val_bill->price == 0) {
                $data_bill['price'] = trans('app.free');
            } else {
                $data_bill['price'] = (string) $val_bill->price . 'ريال';
            }
//            $data_bill['code'] = $val_bill->link;
            $data_bills[] = $data_bill;
        }
        return array('data_bills' => $data_bills, 'total_price' => $total_price);
    }

    public function Insert_view_page($page_type, $lang = 'ar', $api = 0) {
        return Page::updateColumWhere('type', $page_type, 'view_count', 0, $lang);
    }

    public function AllDataPage($this_user, $page_type, $all, $num, $api = 0, $lang = 'ar') {
        if ($api == 0) {
            $lang = $this->lang;
        }
        $get_user = new Class_UserController();
        $view_count_insert = $get_user->Insert_view_page($page_type, $lang);
        $page_data = $get_user->DataPage($this_user->id, $page_type, $all);
        if ($api == 0) {
            $array_data = $get_user->DataUser($this_user, $page_data['name_page'], $num);
            $array_data = array_merge($page_data, $array_data);
            $array_data['user_key'] = $this_user->name;
            return $array_data;
        } else {
            return $page_data;
        }
    }

    public function DataPage($user_id, $page_type, $all = 0) {
        $lang = Language::currentLang(0); //$this->lang;
        $page = Page::get_PageLang($page_type, $lang);
        $name_page = '';
        $contents = [];
        if (!isset($page->id)) {
            $page = Page::get_PageLang($page_type, 'ar');
        }
        if (isset($page->id)) {
            // $lang_id = $page->lang_id;
            $name_page = $page->name;
            if ($all == 1) {
                $contents = PageContent::get_ALLContent($page->id);
            } else {
                $contents = PageContent::get_Content($page->id, $page_type);
            }
        }
        $data_meta['contents'] = $contents;
        $data_meta['name_page'] = $name_page;
        return $data_meta;
    }

    public function DataPageContent($type = 'id', $page_id, $page_type, $col_name = '') {
        if ($type == 'link') {
            $contents = PageContent::get_ContentLink($col_name, $page_id, $page_type);
        } else {
            $contents = PageContent::get_Content($page_id, $page_type);
        }
        return $contents;
    }

}
