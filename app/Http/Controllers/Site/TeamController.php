<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Contact;
use App\User;
use App\Model\Category;
use App\Model\Page;
use App\Model\Options;
use App\Http\Controllers\SiteController;

class TeamController extends SiteController {

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
    public function SubteamSingle(Request $request, $cat_link, $link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $catgeory = Category::where('link', $cat_link)->where('is_active', 1)->first();
            if (isset($catgeory->id)) {
                $data = Category::get_categoryCloum('link', $link, 1);
                if (isset($data->id)) {
                    //Product::updateProductViewCount($data->id);
                    $page = Page::get_typeColum('team');
                    $page_title = $page->title;
                    $title = $page_title . " - " . $catgeory->name . " - " . $data->name . " - " . $this->site_title;
                    $logo_image = $this->logo_image;
                    View::share('title', $title);
                    View::share('activ_menu', 6);
                    $type = 'team';
                    $data_players = $data->childrens->where('type_state', 'player');
                    $players = Category::get_DataTeamUser($data_players);
                    $data_coaches = $data->childrens->whereIn('type_state', ['coach', 'help_coach']);
                    $coaches = Category::get_DataTeamUser($data_coaches);
                    $active_cat_link = $catgeory->link;
                    return view('site.teams.index', compact('logo_image', 'active_cat_link', 'coaches', 'players', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
                } else {
                    return redirect()->back();
//                    return redirect()->route('teams.team.single', $catgeory->link);
                }
            } else {
                return redirect()->back();
//                return redirect()->route('teams.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

    public function UserteamSingle(Request $request, $link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $all_data = Category::get_categoryCloum('link', $link, 1);
            if (isset($all_data->id)) {
                $data = Category::single_DataTeamUser($all_data);
                $catgeory = Category::get_categoryCloum('id', $all_data->parent_id, 1);
                //Product::updateProductViewCount($all_data->id);
                $page = Page::get_typeColum('team');
                $page_title = $page->title;
                $title = $page_title . " - " . $catgeory->name . " - " . $data['name'] . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 6);
                $type = 'team';
                $share_link = route('teams.user.single', $data['link']);
                $share_image = $data['user_image'];
                $share_description = $data['content'];
                return view('site.teams.single', compact('share_link', 'share_description', 'title', 'share_image', 'logo_image', 'data', 'catgeory', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->route('close');
        }
    }

//***************************not use*************************
    public function index(Request $request) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $lang = 'ar';
            $page = Page::get_typeColum('team');
            $page_title = $page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 5);
            $type = 'team';
            $teams = Category::getData_cateorySelect(0, 'team', 'lang', $lang, 1, 0, 0);
            $teams = Product::all_Category_team('team', 1, '', '', $lang, 0, $this->limit, -1, 0);
            $count_team = count($teams);
            $active_cat_link = 'all';
            return view('site.teams.index', compact('logo_image', 'active_cat_link', 'count_team', 'teams', 'teams', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function TeamSingle(Request $request, $cat_link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $catgeory = Category::where('link', $cat_link)->where('is_active', 1)->first();
            if (isset($catgeory->id)) {
                $lang = 'ar';
                $page = Page::get_typeColum('team');
                $page_title = $page->title;
                $title = $page_title . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 5);
                $type = 'team';
                $teams = Category::get_DataTeamUser($catgeory->childrens);
                $count_team = count($teams);
                $active_cat_link = $catgeory->link;
                return view('site.teams.index', compact('logo_image', 'active_cat_link', 'count_team', 'teams', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return redirect()->route('teams.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

}
