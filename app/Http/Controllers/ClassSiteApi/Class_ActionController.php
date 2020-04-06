<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Blog;
use App\Model\Video;
use App\Model\CommentVideo;
use App\Model\CommentBlog;
use App\Model\Comment;
use App\Model\Action;
use App\Model\Options;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_NotifController;

class Class_ActionController extends SiteController {

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

    public function Check_fav_course($post_id, $type = 'video', $type_action = 'like', $current_id = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
        }
        $fav = Action::actionCheckUserId($current_id, $post_id, $type, $type_action);

        return $fav;
    }

    public function get_fav_course($post_id, $type = 'video', $type_action = 'like', $count = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
        }
        $data_fav = Action::get_DataAction($post_id, $type, $type_action, $count);

        return $data_fav;
    }

    public function add_delete_fav_course($post, $type = 'video', $type_action = 'like', $current_id = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
        }
        $check_fav = new Class_ActionController();
        $state_fav = $check_fav->Check_fav_course($post->id, $type, $type_action, $current_id, $api);

        if ($state_fav == 0) {
            $add_fav = Action::insertAction($current_id, $post->id, $type, $type_action);
            $like = $state_action = 1;
        } else {
            $delete_fav = Action::deleteUserAction($current_id, $post->id, $type, $type_action);
            $like = 0;
            $state_action = 2;
        }
        if ($current_id <= 0) {
            $state_action = 0;
        }
        if ($api == 0) {
            return array('like' => $like, 'state_action' => $state_action);
        } else {
            return array('like' => $like);
        }
    }

    public function action_fav_Data($link, $type, $type_action, $current_id = 0, $api = 0) {
        $user_key = $this->user_key;
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
        } else {
            if (empty($lang)) {
                $lang = 'ar';
            }
        }
        $get_data = new Class_CommentController();
        $post = $get_data->get_data($link, $type, $current_id, 1);
        $array_data['state_action'] = -1;
        $array_data['like'] = 0;
        $array_data['num_like'] = 0;
        if (isset($post->id)) {
            $get_action = new Class_ActionController();
            $array_data = $get_action->add_delete_fav_course($post, $type, $type_action, $current_id, $api);
            $array_data['num_like'] = Action::get_DataAction($post->id, $type, $type_action, 1);
        }
        if ($api == 1) {
            $array_data['like'] = (string) $array_data['like'];
            $array_data['num_like'] = (string) $array_data['num_like'];
        } else {
//            $array_data['user_key'] = $user_key;
//            $array_data['post'] = $post;
        }
        return $array_data;
    }

}
