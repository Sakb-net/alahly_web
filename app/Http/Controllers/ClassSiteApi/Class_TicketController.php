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

class Class_TicketController extends SiteController {

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


}
