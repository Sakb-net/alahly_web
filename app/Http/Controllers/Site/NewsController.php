<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Blog;
use App\Model\CommentBlog;
use App\User;
use App\Model\Page;
use App\Model\Options;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_CommentController;

class NewsController extends SiteController {

    public function __construct() {
        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->limit = $this_data['limit'];
        $this->logo_image = $this_data['logo_image'];
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
            $page = Page::get_typeColum('news');
            $page_title = $page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 41);
            $type = 'news';
            $data = Blog::get_BlogActive(1, '', '', 'ar', 0, $this->limit, -1);
            //$data = Blog::dataNews($all_news);
            return view('site.news.index', compact('logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function single(Request $request, $link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $data = Blog::get_blog('link', $link, 'ar', 1);
            if (isset($data->id)) {
                Blog::updateBlogViewCount($data->id);
                $page = Page::get_typeColum('news');
                $page_title = $page->title;
                $title = $page_title . " - " . $data->name . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 41);
                $type = 'blog'; //'news';
                $get_comment = new Class_CommentController();
                $all_comment = $get_comment->get_commentdata($data, 'blog');
                $all_comment['page_title'] = $page_title;
                $all_comment['share_link'] = route('news.single', $all_comment['data']->link);
                $all_comment['share_image'] = $all_comment['data']->image;
                $all_comment['title'] = $title; //$all_comment['data']->name;
                $all_comment['share_description'] = $all_comment['data']->description;
                return view('site.news.single', $all_comment)->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return redirect()->route('news.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

    public function league(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $page = Page::get_typeColum('news');
            $page_title = 'جدول الدوري'; //$page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 41);
            $type = 'news';
            $data = Blog::get_BlogActive(1, '', '', 'ar', 0, $this->limit, -1);
            //$data = Blog::dataNews($all_news);
            return view('site.news.league', compact('logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

}
