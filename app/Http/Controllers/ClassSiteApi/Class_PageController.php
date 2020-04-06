<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Http\Request;
//use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
//use App\Model\Role;
//use App\Model\Language;
use App\Model\Page;
use App\Model\PageContent;
use App\Model\Options;
use App\Model\Contact;
use App\Model\Blog;
use App\Model\Video;
use App\Model\Album;
use App\Model\Match;
use App\Model\Product;
use App\Model\Category;
use App\Model\Calendar;
//use App\Model\DetailsCharge;
use App\Http\Controllers\SiteController;

//use App\Http\Controllers\ClassSiteApi\Class_TicketController;

class Class_PageController extends SiteController {

    public function __construct() {
        $data_site = Options::Site_Option();
        $this->site_open = $data_site['site_open'];
        $this->lang = $data_site['lang'];
        $this->site_title = $data_site['site_title'];
        $this->site_url = $data_site['site_url'];
        $this->current_id = 0;
        if (!empty(Auth::user())) {
            $this->user = Auth::user();
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

    public function Page_Home($lang = 'ar', $limit = 5, $api = 0) {
        $lang = $this->lang;
        $all_news = Blog::get_BlogActive(1, '', '', $lang, 0, $limit, 0);
        $news = Blog::dataNews($all_news, $api);
        $count__news_1 = count($news) - 1;
        $all_videos = Video::get_ALLVideoData(null, 'id', 'DESC', $limit, 0);
        $videos = Video::datavideos($all_videos, $api);
        $count__videos_1 = count($videos) - 1;
        $all_albums = Album::get_ALLAlbumData(null, 'id', 'DESC', $limit, 0);
        $albums = Album::dataAlbum($all_albums, $api);
        $match_data_prev = Match::get_MatchActiveFirst(1, 'prev', 'id', 'DESC');
        $match_perv = Match::get_MatchSingle($match_data_prev, $api);
        $match_data_next = Match::get_MatchActiveFirst(1, 'next', 'id', 'ASC');
        $match_next = Match::get_MatchSingle($match_data_next, $api);
        $allproducts = Product::get_ProductActive('product', 1, '', '', $lang, 0, $limit, 0);
        $products = Product::dataProduct($allproducts, $api);
        $return_data = array('match_next' => $match_next, 'match_perv' => $match_perv, 'news' => $news, 'count__news_1' => $count__news_1, 'videos' => $videos, 'count__videos_1' => $count__videos_1, 'albums' => $albums, 'products' => $products);
        return $return_data;
    }

    public function Page_contactUs($type_page = 'contact', $lang = 'ar', $api = 0, $user_key = '', $user_email = '') {
        if ($api == 0) {
            $lang = $this->lang;
            $user_key = $this->user_key;
            $user_email = $this->user_email;
        }
        Page::updateColumWhere('type', $type_page, 'view_count', 0, $lang);

        $contact_page = $contact_content = $contact_title = $contact_email = $contact_phone = $address = $lat = $long = null;
        $page = Page::get_PageLang('contact', $lang);
        if (isset($page->id)) {
            $contact_content = $page->description;
            $contact_page = $page->name;
            $contact_title = $page->title;
            $content = PageContent::get_Content($page->id, 'contact', 1);
            foreach ($content as $key => $val_cont) {
                if ($val_cont->content_key == 'phone_email') {
                    $contact_phone = $val_cont->content_value;
                    $contact_email = $val_cont->content_etc;
                } elseif ($val_cont->content_key == 'address') {
                    $address = $val_cont->content_value;
                    $long = $val_cont->content_etc;
                    $lat = $val_cont->content_other;
                }
            }
        }
        $return_data = array('title' => $contact_title, 'content' => $contact_content,
            'phone' => $contact_phone, 'email' => $contact_email, 'address' => $address,
            'long' => $long, 'lat' => $lat);
        return $return_data;
    }

    public function Page_champions($api = 0, $lang = 'ar') {
        if ($api == 0) {
            $lang = $this->lang;
        }
        Page::updateColumWhere('type', 'champion', 'view_count', 0, $lang);
        $return_data['teams'] = Category::getData_cateorySelect(0, 'team', 'lang', $lang, 1, 0, 0);
        $return_data['subteams'] = [];
        $all_data = Category::where('type', 'champion')->orderBy('id', 'DESC')->get(); //paginate($this->limit); //where('parent_id','<>', 0)->
        $return_data['data'] = Category::SelectDataCategory($all_data,$api);
        return $return_data;
    }

    public function Page_audience($api = 0, $lang = 'ar') {
        if ($api == 0) {
            $lang = $this->lang;
        }
        Page::updateColumWhere('type', 'audience', 'view_count', 0, $lang);
        $data = Category::LastRowActiveParent('type', 'audience', 0, 1);
        if ($api == 1) {
            $return_data['link'] = $data->link;
            $return_data['name'] = $data->name;
            $return_data['content'] = $data->content;
            $return_data['rate'] = 0;
            $return_data['created_at'] = $data->created_at->format('Y-m-d');
        } else {
            $return_data['data'] = $data;
        }
        $return_data['anwsers'] = Category::get_DataAudiences($data->childrens);
        return $return_data;
    }

    public function Page_calendar($api = 0, $lang = 'ar') {
        if ($api == 0) {
            $lang = $this->lang;
        }
        Page::updateColumWhere('type', 'calendar', 'view_count', 0, $lang);
        $all_data = Calendar::getCalendarType('is_active', 1, 'Calendar', $lang, 'id', 'DESC', 1, -1); //paginate($this->limit); 
        $return_data['data'] = Calendar::get_DataCalendar($all_data, $api);
        return $return_data;
    }

    public function Page_about($api = 0, $lang = 'ar') {
        if ($api == 0) {
            $lang = $this->lang;
        }
        Page::updateColumWhere('type', 'about', 'view_count', 0, $lang);
        $all_title = [];
        $lang_id = $about_name = $about_title = $about_content = $about_image = $about_title_two = $about_content_two = NULL;
        $page = Page::get_PageLang('about', $lang);
        if (!isset($page->id)) {
            $page = Page::get_PageLang('about', 'ar');
        }
        if (isset($page->id)) {
            $lang_id = $page->lang_id;
            $about_name = $page->name;
            $about_title = $page->title;
            $about_content = $page->description;
            $about_image = $page->image;
            $page_content = PageContent::get_Content($page->id, 'about');
            if (isset($page_content->content_value)) {
                $about_title_two = $page_content->content_value;
                $about_content_two = $page_content->content_etc;
                $all_title = json_decode($page_content->content_other);
            }
        }
        if ($api == 1) {
            $about_content = strip_tags($about_content);
            $about_content_two = strip_tags($about_content_two);
        }
        $return_data = array('all_list' => $all_title, 'name' => $about_name, 'title_one' => $about_title, 'content_one' => $about_content, 'title_two' => $about_title_two, 'content_two' => $about_content_two, 'image' => $about_image);
        if ($api == 0) {
            $return_data['lang_id'] = $lang_id;
        }
        return $return_data;
    }

    public function PageContent($type_page = 'home', $lang = 'ar', $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
        }
        Page::updateColumWhere('type', $type_page, 'view_count', 0, $lang);
        $lang_id = $title = $content = $image = $title_content = NULL;
        $page = Page::get_PageLang($type_page, $lang);
        if (!isset($page->id)) {
            $page = Page::get_PageLang($type_page, 'ar');
        }
        if (isset($page->id)) {
            $lang_id = $page->lang_id;
            $title = $page->name;
            $title_content = $page->title;
            $content = $page->description;
            $image = $page->image;
        }
        if ($api == 1) {
            $content = strip_tags($content);
        }
        $return_data = array('title' => $title, 'title_content' => $title_content, 'content' => $content, 'image' => $image);
        if ($api == 0) {
            $return_data['lang_id'] = $lang_id;
        }
        return $return_data;
    }

    public function add_contact_Us($input, $user_id = 0, $api = 0) {
        $state_add = 0;
        if ($api == 0) {
            if (isset($this->user) && !empty($this->user)) {
                $user_id = $this->user->id;
                $input['name'] = $this->user->display_name;
                $input['email'] = $this->user->email;
            }
        }
        $input['attachment'] = NULL;
        $input['is_read'] = 0;
        $input['is_reply'] = 0;
        $contact = Contact::create($input);
        if (!empty($contact)) { //$contact['id']
            User::SendEmailTOUser($user_id, 'contact_form', $input['content'], $input);
            $state_add = 1;
        }
        return array('state_add' => $state_add);
    }

}
