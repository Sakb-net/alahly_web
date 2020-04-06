<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Options;
use App\Model\Role;
use App\User;
use App\Model\Post;
use App\Model\Category;
use App\Model\Comment;
use App\Model\Contact;
use Carbon\Carbon;
use DB;

class OptionController_old extends AdminController {

//********************************settings of site**************************************
    public function options() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $message_close =$message_banner= '';
        $option = Options::whereIn('option_group', ['setting', 'contact', 'meta', 'social'])->pluck('option_value', 'option_key')->toArray();
        foreach ($option as $key => $value) {
            $$key = $value;
        }
        $roles = Role::pluck('display_name', 'id');
        return view('admin.pages.option', compact(
                        'message_banner','msgmain_close', 'message_close', 'user_active', 'post_active', 'comment_active', 'comment_user', 'email_active', 'default_role', 'admin_url', 'description', 'keywords', 'facebook_pixel', 'google_analytic', 'share_image', 'default_image', 'logo_image', 'table_limit', 'pagi_limit', 'roles', 'site_open', 'site_title', 'email', 'phone', 'address', 'site_url', 'facebook', 'youtube', 'whatsapp', 'twitter', 'instagram', 'googleplus'
        ));
    }

    public function optionsStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'site_title' => 'required',
            'site_url' => 'required',
            'admin_url' => 'required|alpha_dash',
//            'email' => 'required|email',
//            'phone' => 'required',
//            'table_limit' => 'required|numeric',
            'pagi_limit' => 'required|numeric',
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'google_analytic' && $key != 'facebook_pixel' && $key != 'description' && $key != 'keywords') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        Options::updateOption("site_title", $input['site_title'], 0, 'setting');
        Options::updateOption("site_open", $input['site_open'], 0, 'setting');
        Options::updateOption("msgmain_close", $input['msgmain_close'], 0, 'setting');
        Options::updateOption("message_close", $input['message_close'], 0, 'setting');
        Options::updateOption("site_url", $input['site_url'], 0, 'setting');
        Options::updateOption("admin_url", $input['admin_url'], 0, 'setting');
        Options::updateOption("pagi_limit", $input['pagi_limit'], 0, 'setting');
//        Options::updateOption("table_limit", $input['table_limit'],0,'setting');
        Options::updateOption("default_role", $input['default_role'], 0, 'setting');
        Options::updateOption("user_active", $input['user_active'], 0, 'setting');
//        Options::updateOption("email_active", $input['email_active'],0,'setting');
//        Options::updateOption("post_active", $input['post_active'],0,'setting');
//        Options::updateOption("comment_active", $input['comment_active'],0,'setting');
//        Options::updateOption("comment_user", $input['comment_user'],0,'setting');
//        Options::updateOption("email", $input['email'], 1, 'contact');
//        Options::updateOption("phone", $input['phone'], 1, 'contact');
//        Options::updateOption("address", $input['address'], 1, 'contact');

        Options::updateOption("facebook", $input['facebook'], 1, 'social');
        Options::updateOption("twitter", $input['twitter'], 1, 'social');
        Options::updateOption("googleplus", $input['googleplus'], 1, 'social');
        Options::updateOption("youtube", $input['youtube'], 1, 'social');
        Options::updateOption("instagram", $input['instagram'], 1, 'social');
        Options::updateOption("whatsapp", $input['whatsapp'], 1, 'social');

        Options::updateOption("facebook_pixel", $input['facebook_pixel'], 1, 'meta');
        Options::updateOption("google_analytic", $input['google_analytic'], 1, 'meta');
        Options::updateOption("description", $input['description'], 1, 'meta');
        Options::updateOption("keywords", $input['keywords'], 1, 'meta');
        Options::updateOption("message_banner", $input['message_banner'], 1, 'meta');
        Options::updateOption("logo_image", $input['logo_image'], 1, 'meta');
        Options::updateOption("share_image", $input['share_image'], 1, 'meta');
        Options::updateOption("default_image", $input['default_image'], 1, 'meta');

        return redirect($input['admin_url'] . '/options')->with('success', 'Options update successfully');
//        return redirect()->route('admin.options')->with('success', 'Options update successfully');
    }

    public function sendMessage() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $option = Options::whereIn('option_group', ['setting', 'contact', 'meta', 'social'])->pluck('option_value', 'option_key')->toArray();
        foreach ($option as $key => $value) {
            $$key = $value;
        }
        $roles = Role::pluck('display_name', 'id');
        return view('admin.pages.option', compact(
                        'user_active', 'post_active', 'comment_active', 'comment_user', 'email_active', 'default_role', 'admin_url', 'description', 'keywords', 'facebook_pixel', 'google_analytic', 'share_image', 'default_image', 'logo_image', 'table_limit', 'pagi_limit', 'roles', 'site_open', 'site_title', 'email', 'phone', 'address', 'site_url', 'facebook', 'youtube', 'whatsapp', 'twitter', 'instagram', 'googleplus'
        ));
    }

    public function sendMessageStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'site_title' => 'required',
            'site_url' => 'required',
            'admin_url' => 'required|alpha_dash',
//            'email' => 'required|email',
//            'phone' => 'required',
//            'table_limit' => 'required|numeric',
            'pagi_limit' => 'required|numeric',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'google_analytic' && $key != 'facebook_pixel' && $key != 'description' && $key != 'keywords') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        Options::updateOption("site_title", $input['site_title'], 0, 'setting');
        Options::updateOption("site_open", $input['site_open'], 0, 'setting');
        Options::updateOption("site_url", $input['site_url'], 0, 'setting');
        Options::updateOption("admin_url", $input['admin_url'], 0, 'setting');
        Options::updateOption("pagi_limit", $input['pagi_limit'], 0, 'setting');
//        Options::updateOption("table_limit", $input['table_limit'],0,'setting');
        Options::updateOption("default_role", $input['default_role'], 0, 'setting');
        Options::updateOption("user_active", $input['user_active'], 0, 'setting');
//        Options::updateOption("email_active", $input['email_active'],0,'setting');
        Options::updateOption("post_active", $input['post_active'], 0, 'setting');
//        Options::updateOption("comment_active", $input['comment_active'],0,'setting');
//        Options::updateOption("comment_user", $input['comment_user'],0,'setting');
//        Options::updateOption("email", $input['email'], 1, 'contact');
//        Options::updateOption("phone", $input['phone'],1,'contact');
//        Options::updateOption("address", $input['address'], 1, 'contact');

        Options::updateOption("facebook", $input['facebook'], 1, 'social');
        Options::updateOption("twitter", $input['twitter'], 1, 'social');
        Options::updateOption("googleplus", $input['googleplus'], 1, 'social');
        Options::updateOption("youtube", $input['youtube'], 1, 'social');
        Options::updateOption("instagram", $input['instagram'], 1, 'social');
        Options::updateOption("whatsapp", $input['whatsapp'], 1, 'social');

        Options::updateOption("facebook_pixel", $input['facebook_pixel'], 1, 'meta');
        Options::updateOption("google_analytic", $input['google_analytic'], 1, 'meta');
        Options::updateOption("description", $input['description'], 1, 'meta');
        Options::updateOption("keywords", $input['keywords'], 1, 'meta');
        Options::updateOption("logo_image", $input['logo_image'], 1, 'meta');
        Options::updateOption("share_image", $input['share_image'], 1, 'meta');
        Options::updateOption("default_image", $input['default_image'], 1, 'meta');

        return redirect($input['admin_url'] . '/options')->with('success', 'Options update successfully');
//        return redirect()->route('admin.options')->with('success', 'Options update successfully');
    }

//********************************pages of site**************************************
    public function homeOption() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
//        $all_title = Options::where('option_group', 'home')->get();'all_title',
//        $image_banner = Options::where('option_key', 'image_banner')->where('option_group', 'banner')->first();
        $image_back = Options::where('option_key', 'image_back')->where('option_group', 'home')->first();
        $image_link = $image_back->option_value;

        $post_active = 1;
        return view('admin.pages.home', compact( 'about_title', 'about_content', 'about_image', 'image_link', 'post_active'));
    }

    public function homeStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        //whereNotIn('option_value', 'home')->
        $delet = new Options();
        $delet->deleteOptionGroup('home');

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'titleHome' && $key != 'title_addHome') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
//        Options::updateOption("image_banner", $input['image_banner'], 1, 'banner');
        Options::updateOption("image_back", $input['image_back'], 1, 'home');

        return redirect()->route('admin.pages.home')->with('success', 'Home update successfully');
    }
    
    public function homeStore_try(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        //whereNotIn('option_value', 'home')->
        $delet = new Options();
        $delet->deleteOptionGroup('home');

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'titleHome' && $key != 'title_addHome') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Options::updateOption("image_banner", $input['image_banner'], 1, 'banner');

        $title_Home = isset($_POST['titleHome']) ? $_POST['titleHome'] : array();
        $title_addHome = isset($_POST['title_addHome']) ? $_POST['title_addHome'] : array();
        if (!empty($title_Home)) {
            foreach ($title_Home as $title_Home_value) {
                $input['id'] = (int) $title_Home_value['title_id'];
                $input['name'] = trim(filter_var($title_Home_value['name'], FILTER_SANITIZE_STRING));
                $current_title_Home_id[] = $input['id'];
                if ($input['name'] != '') {
                    Options::updateOptionHome("home_title", $input['name'], 0, 'home');
                }
            }
        }

        $input = [];
        if (!empty($title_addHome)) {
            foreach ($title_addHome as $title_addHome_value) {
                $input['name'] = trim(filter_var($title_addHome_value['name'], FILTER_SANITIZE_STRING));
                if ($input['name'] != '') {
                    Options::updateOptionHome("home_title", $input['name'], 0, 'home');
                }
            }
        }

        return redirect()->route('admin.pages.home')->with('success', 'Home update successfully');
    }

    public function contact() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $contact_page = Options::where('option_key', 'contact_page')->value('option_value');
        $contact_title = Options::where('option_key', 'contact_title')->value('option_value');
        $contact_content = Options::where('option_key', 'contact_content')->value('option_value');
        $address = Options::where('option_key', 'contact_address')->value('option_value');
        $contact_email = Options::where('option_key', 'contact_email')->value('option_value');
        $contact_phone = Options::where('option_key', 'contact_phone')->value('option_value');
        $lat = Options::where('option_key', 'contact_latitude')->value('option_value');
        $long = Options::where('option_key', 'contact_longitude')->value('option_value');

        return view('admin.pages.contact', compact('lat', 'long', 'address', 'contact_email', 'contact_phone', 'contact_page', 'contact_title', 'contact_content'));
    }

    public function contactStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
//            'contact_page' => 'required',
//            'contact_title' => 'required',
//            'contact_content' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'contact_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Options::updateOption("contact_page", $input['contact_page'], 1, 'contact');
        Options::updateOption("contact_title", $input['contact_title'], 0, 'contact');
        Options::updateOption("contact_content", $input['contact_content'], 0, 'contact');
        Options::updateOption("contact_email", $input['contact_email'], 1, 'contact');
        Options::updateOption("contact_address", $input['address'], 1, 'contact');
        Options::updateOption("contact_phone", $input['contact_phone'], 1, 'contact');
        Options::updateOption("contact_longitude", $input['longitude'], 1, 'contact');
        Options::updateOption("contact_latitude", $input['latitude'], 1, 'contact');

        return redirect()->route('admin.pages.contact')->with('success', 'Contact update successfully');
    }

    public function about() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $about_image = $about_content = $about_page = $about_title = NULL;
        $array_option_key = ['about_page', 'about_title', 'about_content', 'about_image'];
        $All_options = Options::get_Option('setting', $array_option_key);
        foreach ($All_options as $key => $value) {
            $$key = $value;
        }
        return view('admin.pages.about', compact('about_page', 'about_title', 'about_content', 'about_image'));
    }

    public function aboutStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'about_page' => 'required',
            'about_title' => 'required',
            'about_content' => 'required',
            'about_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'about_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Options::updateOption("about_image", $input['about_image'], 0, 'about');

        Options::updateOption("about_page", $input['about_page'], 1, 'about');
        Options::updateOption("about_title", $input['about_title'], 0, 'about');
        Options::updateOption("about_content", $input['about_content'], 0, 'about');
        Options::updateOption("about_image", $input['about_image'], 0, 'about');

        return redirect()->route('admin.pages.about')->with('success', 'About update successfully');
    }

    public function goal() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $goal_image = $goal_content = $goal_page = $goal_title = NULL;
        $array_option_key = ['goal_page', 'goal_title', 'goal_content', 'goal_image'];
        $All_options = Options::get_Option('setting', $array_option_key);
        foreach ($All_options as $key => $value) {
            $$key = $value;
        }
        return view('admin.pages.goal', compact('goal_page', 'goal_title', 'goal_content', 'goal_image'));
    }

    public function goalStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'goal_page' => 'required',
            'goal_title' => 'required',
            'goal_content' => 'required',
            'goal_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'goal_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Options::updateOption("goal_image", $input['goal_image'], 0, 'goal');

        Options::updateOption("goal_page", $input['goal_page'], 1, 'goal');
        Options::updateOption("goal_title", $input['goal_title'], 0, 'goal');
        Options::updateOption("goal_content", $input['goal_content'], 0, 'goal');
        Options::updateOption("goal_image", $input['goal_image'], 0, 'goal');

        return redirect()->route('admin.pages.goal')->with('success', 'About update successfully');
    }

    public function message() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $message_image = $message_content = $message_page = $message_title = NULL;
        $array_option_key = ['message_page', 'message_title', 'message_content', 'message_image'];
        $All_options = Options::get_Option('setting', $array_option_key);
        foreach ($All_options as $key => $value) {
            $$key = $value;
        }
        return view('admin.pages.message', compact('message_page', 'message_title', 'message_content', 'message_image'));
    }

    public function messageStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'message_page' => 'required',
            'message_title' => 'required',
            'message_content' => 'required',
            'message_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'message_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Options::updateOption("message_image", $input['message_image'], 0, 'message');

        Options::updateOption("message_page", $input['message_page'], 1, 'message');
        Options::updateOption("message_title", $input['message_title'], 0, 'message');
        Options::updateOption("message_content", $input['message_content'], 0, 'message');
        Options::updateOption("message_image", $input['message_image'], 0, 'message');

        return redirect()->route('admin.pages.message')->with('success', 'About update successfully');
    }

    public function manager() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $manager_image = $manager_content = $manager_page = $manager_title = NULL;
        $array_option_key = ['manager_page', 'manager_title', 'manager_content', 'manager_image'];
        $All_options = Options::get_Option('setting', $array_option_key);
        foreach ($All_options as $key => $value) {
            $$key = $value;
        }
        return view('admin.pages.manager', compact('manager_page', 'manager_title', 'manager_content', 'manager_image'));
    }

    public function managerStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'manager_page' => 'required',
            'manager_title' => 'required',
            'manager_content' => 'required',
            'manager_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'manager_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Options::updateOption("manager_image", $input['manager_image'], 0, 'manager');

        Options::updateOption("manager_page", $input['manager_page'], 1, 'manager');
        Options::updateOption("manager_title", $input['manager_title'], 0, 'manager');
        Options::updateOption("manager_content", $input['manager_content'], 0, 'manager');
        Options::updateOption("manager_image", $input['manager_image'], 0, 'manager');

        return redirect()->route('admin.pages.manager')->with('success', 'About update successfully');
    }

}
