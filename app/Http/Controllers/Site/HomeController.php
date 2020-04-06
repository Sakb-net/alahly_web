<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\ContactFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use App\Model\Options;
use App\Model\Blog;
use App\Model\Page;
use App\Model\Video;
use App\Model\Album;
use App\Model\Match;
use App\Model\Product;
use App\Model\Category;
use App\Model\Calendar;
use App\Model\Contact;
use Auth;
use Mail;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_PageController;

class HomeController extends SiteController {

    public function __construct() {
        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->logo_image = $this_data['logo_image'];
        $this->limit = $this_data['limit'];
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
    public function home() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('home');
            $logo_image = $this->logo_image;
            $title = $page->title . " - " . $this->site_title;
            $user_key = $this->user_key;
            View::share('title', $title);
            View::share('activ_menu', 1);
            $news = Blog::get_BlogActive(1, '', '', $lang, 0, 5, 0);
            $count__news_1 = count($news) - 1;
            $videos = Video::get_ALLVideoData(null, 'id', 'DESC', 4, 0);
            $count__videos_1 = count($videos) - 1;
            $gallery = Album::get_ALLAlbumData(null, 'id', 'DESC', 4, 0);
            $match_data_prev = Match::get_MatchActiveFirst(1, 'prev', 'id', 'DESC');
            $match_perv = Match::get_MatchSingle($match_data_prev);
            $match_data_next = Match::get_MatchActiveFirst(1, 'next', 'id', 'ASC');
            $match_next = Match::get_MatchSingle($match_data_next);
            $all_products = Product::get_ProductActive('product', 1, '', '', $lang, 0, 6, 0);
            $products = Product::dataProduct($all_products, 0);
            return view('site.home', compact('match_next', 'match_perv', 'products', 'gallery', 'videos', 'count__videos_1', 'news', 'count__news_1', 'logo_image', 'user_key'));
        } else {
            return redirect()->route('close');
        }
    }

    public function champions() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('champion');
            Page::updateColumWhere('type', 'champion', 'view_count', 0, $lang);
            $title = $page->title . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 8);
            $return_data['teams'] = Category::getData_cateorySelect(0, 'team', 'lang', $lang, 1, 0, 0);
            $return_data['subteams'] = [];
            $return_data['data'] = Category::where('type', 'champion')->orderBy('id', 'DESC')->get(); //paginate($this->limit); //where('parent_id','<>', 0)->
            $return_data['page_title'] = $page->title;
            return view('site.pages.champions', $return_data);
        } else {
            return redirect()->route('close');
        }
    }

    public function audience() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('audience');
            Page::updateColumWhere('type', 'audience', 'view_count', 0, $lang);
            $title = $page->title . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 9);
            $data = Category::LastRowActiveParent('type', 'audience', 0, 1);
            $return_data['data'] = $data;
            $return_data['anwsers'] = Category::get_DataAudiences($data->childrens);
            $return_data['page_title'] = $page->title;
            return view('site.pages.audience', $return_data);
        } else {
            return redirect()->route('close');
        }
    }

    public function game() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('game');
            $title = $page->title . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 10);
            $return_data['data'] = [];
            $return_data['page_title'] = $page->title;
            return view('site.pages.game', $return_data);
        } else {
            return redirect()->route('close');
        }
    }

    public function calendar() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('calendar');
            $title = $page->title . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 11);
            $all_data = Calendar::getCalendarType('is_active', 1, 'Calendar', $lang, 'id', 'DESC', 1, -1); //paginate($this->limit); 
            $return_data['data'] = Calendar::get_DataCalendar($all_data);
            $return_data['page_title'] = $page->title;
            return view('site.pages.calendar', $return_data);
        } else {
            return redirect()->route('close');
        }
    }

    public function about() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $data_page = new Class_PageController();
            $return_data = $data_page->Page_about();
            $title = $return_data['name'] . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 2);
            $return_data['page_title'] = $return_data['name']; //'عن النادي';
            return view('site.pages.about', $return_data);
        } else {
            return redirect()->route('close');
        }
    }

    public function terms() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $data_page = new Class_PageController();
            $return_data = $data_page->PageContent('terms');
            $title = $return_data['terms_title'] . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 13);
            $return_data['page_title'] = 'الشروط والاحكام';
            return view('site.pages.terms', $return_data);
        } else {
            return redirect()->route('close');
        }
    }

    public function contact() {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $data_page = new Class_PageController();
            $return_data = $data_page->Page_contactUs();
            $title = $return_data['title'] . " - " . $this->site_title;
            View::share('title', $title);
            View::share('activ_menu', 12);
            $return_data['correct_form'] = session()->get('correct_form');
            session()->forget('correct_form');
            $return_data['page_title'] = 'اتصل بنا';
            return view('site.pages.contact', $return_data); //, 'phone', 'email', 'address'
        } else {
            return redirect()->route('close');
        }
    }

    public function contactStore(ContactFormRequest $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $email = DB::table('options')->where('option_key', 'email')->value('option_value');
            $user_email = $request->get('email');

            $name = stripslashes(trim(filter_var($request->get('name'), FILTER_SANITIZE_STRING)));
            $type = stripslashes(trim(filter_var($request->get('type'), FILTER_SANITIZE_STRING)));
            $useremail = stripslashes(trim(filter_var($request->get('email'), FILTER_SANITIZE_STRING)));
            $user_message = stripslashes(trim(filter_var($request->get('message'), FILTER_SANITIZE_STRING)));
            $visitor = $request->ip();

            $user_id = NULL;
            $user_account = Auth::user();
            if (!empty($user_account)) {
                $user_id = $user_account->id;
            }
            $site_title = $this->site_title;
            $contact = new Contact();
            $contact->insertContact($user_id, $visitor, $name, $useremail, $user_message, $type);
//          $emailClient = 'social@baims.com';
//          $link = URL::to('/') . "/resetpassword/$token";//URL::to('/') . "/client/$linkCllient";
//          $link = route('home');
            Mail::send('emails.contact', array(
                'name' => $name,
                'email' => $useremail,
                'type' => $type, //title
                'user_message' => $user_message
                    ), function($message) use ($email, $user_email, $site_title) {
                $message->from($user_email);
                $message->to($email, $site_title)->subject('Contact US');
            });
            session()->put('correct_form', trans('app.send_success'));
            return redirect()->route('site.contact'); //->with('success', 'Message sent successfully');
        } else {
            return redirect()->route('close');
        }
    }

//**************************goto payment for mobile App***********************************
    public function mobile(Request $request, $checkoutId = '') {
        if (!empty($checkoutId)) {
            $array_data['checkoutId'] = $checkoutId; //$_REQUEST['checkoutId'];
            $array_data['shopperResultUrl'] = 'http://alahliclub.sakb.net/api/v1/confirmPayment'; // 'https://hyperpay.docs.oppwa.com/tutorials/integration-guide';      
            View::share('title', 'ادفع الان');
            return view('site.payment.mobile', $array_data);
        } else {
            return redirect()->route('home');
        }
    }

}
