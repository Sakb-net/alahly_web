<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Page;
use App\Model\PageContent;
use App\User;
use App\Model\Options;

//use App\Model\Category;
//use App\Model\Comment;
//use App\Model\Contact;
//use Carbon\Carbon;
//use DB;

class pageController extends AdminController {

//********************************pages of site**************************************
    public function homeOption() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
//        $all_title = Options::where('option_group', 'home')->get();'all_title',
//        $image_banner = Options::where('option_key', 'image_banner')->where('option_group', 'banner')->first();
        $image_back = Options::where('option_key', 'image_back')->where('option_group', 'home')->first();
        $image_link = $image_back->page_value;

        $post_active = 1;
        return view('admin.pages.home', compact('about_title', 'about_content', 'about_image', 'image_link', 'post_active'));
    }

    public function homeStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        //whereNotIn('page_value', 'home')->
        $delet = new Page();
        $delet->deleteOptionGroup('home');

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'titleHome' && $key != 'title_addHome') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
//        Options::updateOption("image_banner", $input['image_banner'], 1, 'banner');
        Options::updateOption("image_back", $input['image_back'], 1, 'home');

        return redirect()->route('admin.pages.home')->with('success', 'Update successfully');
    }

    public function homeStore_try(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        //whereNotIn('page_value', 'home')->
        $delet = new Page();
        $delet->deleteOptionGroup('home');

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'titleHome' && $key != 'title_addHome') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Page::updateOption("image_banner", $input['image_banner'], 1, 'banner');

        $title_Home = isset($_POST['titleHome']) ? $_POST['titleHome'] : array();
        $title_addHome = isset($_POST['title_addHome']) ? $_POST['title_addHome'] : array();
        if (!empty($title_Home)) {
            foreach ($title_Home as $title_Home_value) {
                $input['id'] = (int) $title_Home_value['title_id'];
                $input['name'] = trim(filter_var($title_Home_value['name'], FILTER_SANITIZE_STRING));
                $current_title_Home_id[] = $input['id'];
                if ($input['name'] != '') {
                    Page::updateOptionHome("home_title", $input['name'], 0, 'home');
                }
            }
        }

        $input = [];
        if (!empty($title_addHome)) {
            foreach ($title_addHome as $title_addHome_value) {
                $input['name'] = trim(filter_var($title_addHome_value['name'], FILTER_SANITIZE_STRING));
                if ($input['name'] != '') {
                    Page::updateOptionHome("home_title", $input['name'], 0, 'home');
                }
            }
        }

        return redirect()->route('admin.pages.home')->with('success', 'Home update successfully');
    }

    public function contact() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $contact_page = $contact_content = $contact_title = $contact_email = $contact_phone = $address = $lat = $long = null;
        $All_pages = Page::get_typeColum('contact', 'ar');
        if (isset($All_pages->id)) {
            $contact_content = $All_pages->description;
            $contact_page = $All_pages->name;
            $contact_title = $All_pages->title;
            $content = PageContent::get_Content($All_pages->id, 'contact', 1);
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

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'contact_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $page_id = Page::updatePage('contact', $input['contact_page'], 'ar', $input['contact_title'], $input['contact_content']);
        PageContent::updateContentKey($page_id, 'contact', 'phone_email', $input['contact_phone'], $input['contact_email'], '');
        PageContent::updateContentKey($page_id, 'contact', 'address', $input['address'], $input['longitude'], $input['latitude']);
        return redirect()->route('admin.pages.contact')->with('success', 'Update successfully');
    }

    public function about() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $all_title = [];
        $about_image = $about_content = $about_title = $about_content_two = $about_title_two = $about_page = NULL;
        $All_pages = Page::get_typeColum('about', 'ar');
        if (isset($All_pages->id)) {
            $about_image = $All_pages->image;
            $about_content = $All_pages->description;
            $about_page = $All_pages->name;
            $about_title = $All_pages->title;
            $content = PageContent::get_Content($All_pages->id, 'about');
            if (isset($content->id)) {
                $about_title_two = $content->content_value;
                $about_content_two = $content->content_etc;
                $all_title = json_decode($content->content_other);
            }
        }

        return view('admin.pages.about', compact('about_page', 'all_title', 'about_title', 'about_content', 'about_title_two', 'about_content_two', 'about_image'));
    }

    public function aboutStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'about_page' => 'required',
            'about_title' => 'required',
            'about_content' => 'required',
//            'about_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'about_content' && $key != 'titleHome' && $key != 'title_addHome') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        $page_id = Page::updatePage('about', $input['about_page'], 'ar', $input['about_title'], $input['about_content'], $input['about_image']);
        $all_list = [];
        $title_Home = isset($_POST['titleHome']) ? $_POST['titleHome'] : array();
        $title_addHome = isset($_POST['title_addHome']) ? $_POST['title_addHome'] : array();
        if (!empty($title_Home)) {
            foreach ($title_Home as $title_Home_value) {
                $name_list = trim(filter_var($title_Home_value['name'], FILTER_SANITIZE_STRING));
                if ($name_list != '') {
                    $all_list[] = $name_list;
                }
            }
        }
        if (!empty($title_addHome)) {
            foreach ($title_addHome as $title_addHome_value) {
                $name_list = trim(filter_var($title_addHome_value['name'], FILTER_SANITIZE_STRING));
                if ($name_list != '') {
                    $all_list[] = $name_list;
                }
            }
        }
        $all_list = json_encode($all_list);
        PageContent::updateContent($page_id, 'about', 'content', $input['about_title_two'], $input['about_content_two'], $all_list);
        return redirect()->route('admin.pages.about')->with('success', 'Update successfully');
    }

    public function goal() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $goal_image = $goal_content = $goal_page = $goal_title = NULL;
        $All_pages = Page::get_typeColum('goal', 'ar');
        if (isset($All_pages->id)) {
            $goal_image = $All_pages->image;
            $goal_content = $All_pages->description;
            $goal_page = $All_pages->name;
            $goal_title = $All_pages->title;
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
//            'goal_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'goal_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Page::updatePage('goal', $input['goal_page'], 'ar', $input['goal_title'], $input['goal_content'], $input['goal_image']);

        return redirect()->route('admin.pages.goal')->with('success', 'Update successfully');
    }

    public function message() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $message_image = $message_content = $message_page = $message_title = NULL;
        $All_pages = Page::get_typeColum('message', 'ar');
        if (isset($All_pages->id)) {
            $message_image = $All_pages->image;
            $message_content = $All_pages->description;
            $message_page = $All_pages->name;
            $message_title = $All_pages->title;
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
//            'message_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'message_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Page::updatePage('message', $input['message_page'], 'ar', $input['message_title'], $input['message_content'], $input['message_image']);

        return redirect()->route('admin.pages.message')->with('success', 'Update successfully');
    }

    public function terms() {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }
        $terms_image = $terms_content = $terms_page = $terms_title = NULL;
        $All_pages = Page::get_typeColum('terms', 'ar');
        if (isset($All_pages->id)) {
            $terms_image = $All_pages->image;
            $terms_content = $All_pages->description;
            $terms_page = $All_pages->name;
            $terms_title = $All_pages->title;
        }
        return view('admin.pages.terms', compact('terms_page', 'terms_title', 'terms_content', 'terms_image'));
    }

    public function termsStore(Request $request) {
        if (!$this->user->can('access-all')) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'terms_page' => 'required',
            'terms_title' => 'required',
            'terms_content' => 'required',
//            'terms_image' => 'required',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != 'terms_content') {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        Page::updatePage('terms', $input['terms_page'], 'ar', $input['terms_title'], $input['terms_content'], $input['terms_image']);

        return redirect()->route('admin.pages.terms')->with('success', 'Update successfully');
    }

}
