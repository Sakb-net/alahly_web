<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Match;
use App\Model\Page;
use App\Model\Options;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_CommentController;

class MatchController extends SiteController {

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
            $page = Page::get_typeColum('match');
            $page_title = $page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 7);

            $type = 'match';
            $data = Match::get_MatchActive(1, '', '', 'ar', 'all', 0, $this->limit, -1);
            //$data = Match::dataMatch($all_matches);
            return view('site.matches.index', compact('logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function nextMatch(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $page = Page::get_typeColum('match');
            $page_title = $page->title . ' القادمة';
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 71);
            $type = 'match';
            $data = Match::get_MatchActive(1, '', '', 'ar', 'next', 0, $this->limit, -1);
//            $data = Match::dataMatch($all_matches);
            return view('site.matches.next', compact('logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function previousMatch(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $page = Page::get_typeColum('match');
            $page_title = $page->title . ' السابقة';
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 72);
            $type = 'match';
            $data = Match::get_MatchActive(1, '', '', 'ar', 'prev', 0, $this->limit, -1);
            //$data = Match::dataMatch($all_matches);
            return view('site.matches.previous', compact('logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function single(Request $request, $link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $data = Match::get_match('link', $link, 'ar', 1);
            if (isset($data->id)) {
                Match::updateMatchViewCount($data->id);
                $page = Page::get_typeColum('match');
                $page_title = $page->title;
                $title = $page_title . " - " . $data->name . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 7);
                $type = 'match';
                $get_comment = new Class_CommentController();
                $all_comment = $get_comment->get_commentdata($data, 'match');
                $all_comment['page_title'] = $page_title;
                return view('site.matches.single', $all_comment)->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return redirect()->route('matches.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

}
