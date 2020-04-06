<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
//use App\Model\Post;
use App\Model\Comment;
use App\Model\UserNotif;
use App\Model\Options;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_TicketController;

class Class_NotifController extends SiteController {

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

    public function Update_readNotif($array_type_id = []) {
        $lang = $this->lang;
        $current_id = $this->current_id;
        $update = UserNotif::updateOrderColumTwo('to_id', $current_id, 'type_id', $array_type_id, 'is_read', 1);
        return $update;
    }

    public function insert_NotificationTableComment($current_course, $post, $comment, $current_id = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
            $get_course = new Class_TicketController();
            $current_course = $get_course->get_courseType($post);
        }
        $add_notif = new Class_NotifController();
        $all_user = $add_notif->get_UserSendNotifSubscribe($current_course, $comment);
        $add = UserNotif::insert_SendNotification($all_user, $current_course, $current_id, $post->id, $post->type, $comment['type'], $comment['id'], $comment['content'], 0, 1);
        return $add;
    }

    public function get_UserSendNotifSubscribe($current_course, $comment) {
        $all_user = [];
        $instructor_id = $current_course->user_id;
        //get user 
        if ($comment['user_id'] != $instructor_id) {
            //get Instructor
            $all_user[] = $current_course->user;
        }
        //get student
        if ($comment['parent_one_id'] != Null && $comment['parent_two_id'] != Null) { //parent (comment or question)
            //$comment['parent_one_id'] == $comment['parent_two_id'] first_child parent (answer)
            $parent_comment = Comment::commentLink('parent_one_id', $comment['parent_one_id'], 1, '', 1);
            foreach ($parent_comment as $key_pat => $val_pat) {
                if (!empty($val_pat->user) && $val_pat->user_id != $instructor_id && $comment['user_id'] != $val_pat->user_id) {
                    $all_user[] = $val_pat->user;
                }
            }
        }
        return $all_user;
    }

    public function get_UserSendNotifSubscribe_old($current_course, $comment) {
        $all_user = [];
        $instructor_id = $current_course->user_id;
        //get user 
        if ($comment['user_id'] != $instructor_id) {
            //get Instructor
            $all_user[] = $current_course->user;
        }
        //get student
        if ($comment['parent_one_id'] != Null && $comment['parent_two_id'] != Null) { //parent (comment or question)
            //$comment['parent_one_id'] == $comment['parent_two_id'] first_child parent (answer)
            $parent_comment = Comment::commentLink('id', $comment['parent_one_id'], 1, '');
            if (!empty($parent_comment->user) && $parent_comment->user_id != $instructor_id && $comment['user_id'] != $parent_comment->user_id) {
                $all_user[] = $parent_comment->user;
            }
            if ($comment['parent_one_id'] != $comment['parent_two_id']) { //child first_child  (repaly)
                $first_child = Comment::commentParent($comment['parent_one_id'], $comment['parent_one_id'], 1, '');
                if (!empty($first_child->user) && $first_child->user_id != $instructor_id && $comment['user_id'] != $first_child->user_id) {
                    $all_user[] = $first_child->user;
                }
            }
        }
        return $all_user;
    }

}
