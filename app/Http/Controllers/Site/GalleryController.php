<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Model\Page;
use App\User;
use App\Model\Album;
use App\Model\Options;
use App\Http\Controllers\SiteController;

class GalleryController extends SiteController {

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
            $page = Page::get_typeColum('album');
            $page_title = $page->title;
            $title = $page_title . " - " . $this->site_title;
            $logo_image = $this->logo_image;
            View::share('title', $title);
            View::share('activ_menu', 42);
            $type = 'album';
            $data = Album::get_ALLAlbumData(null, 'id', 'DESC', $this->limit, -1);
            //$data = Album::dataData($all_gallery);
            return view('site.gallery.index', compact('logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return redirect()->route('close');
        }
    }

    public function single(Request $request, $link) {
        if ($this->site_open == 1 || $this->site_open == "1") {
            $data = Album::get_albumColum('link', $link, 1);
            if (isset($data->id)) {
                Album::updateAlbumViewCount($data->id);
                $page = Page::get_typeColum('album');
                $page_title = $page->title;
                $title = $page_title . " - " . $data->name . " - " . $this->site_title;
                $logo_image = $this->logo_image;
                View::share('title', $title);
                View::share('activ_menu', 42);
                $type = 'album';
                $sub_albums = Album::get_ALLAlbumData($data->id);
                $share_link = route('gallery.single', $data->link);
                $share_image = $data->image;
                $share_description = $data->description;
                return view('site.gallery.single', compact('share_link','share_description','title','share_image','sub_albums', 'logo_image', 'data', 'type', 'page_title'))->with('i', ($request->input('page', 1) - 1) * 5);
            } else {
                return redirect()->route('gallery.index');
            }
        } else {
            return redirect()->route('close');
        }
    }

}
