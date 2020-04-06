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

class optionController extends AdminController {

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

        return redirect($input['admin_url'] . '/options')->with('success', 'Update successfully');
//        return redirect()->route('admin.options')->with('success', 'Update successfully');
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

        return redirect($input['admin_url'] . '/options')->with('success', 'Update successfully');
//        return redirect()->route('admin.options')->with('success', 'Update successfully');
    }
//********************************pages of site**************************************
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

        return redirect()->route('admin.pages.contact')->with('success', 'Update successfully');
    }

}
