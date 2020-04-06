<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClassSiteApi\Class_CommentController;
use App\Http\Controllers\SiteController;
use App\User;
use App\Model\Options;

class AjaxCommentController extends SiteController {

    public function __construct() {
        // parent::__construct();
//        $this->middleware('auth');
//        $this->middleware(function ($request, $next) {
//            $this->user = auth()->user();
//            return $next($request);
//        });

        $this_data = Options::Site_Option();
        $this->site_open = $this_data['site_open'];
        $this->site_title = $this_data['site_title'];
        $this->limit = $this_data['limit'];
        $this->current_id = $this_data['current_id'];
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

//**************************************add_delete_fav***************************************************
    public function add_delete_fav(Request $request) {
        if ($request->ajax() && isset(Auth::user()->id)) {
            $response = $type = $cou_link = '';
            foreach ($request->input() as $key => $value) {
                $$key = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            if (in_array($type, ['blog', 'video', 'product'])) {
                $get_course = new Class_ActionController();
                $result = $get_course->action_fav_Data($link, $type, 'like', Auth::user()->id, 0);
            } elseif (in_array($type, ['comment', 'comment_blog', 'comment_video', 'comment_product'])) {
                $type_comment = 'comment';
                if ($type == 'comment_blog') {
                    $type_comment = 'blog';
                } elseif ($type == 'comment_video') {
                    $type_comment = 'video';
                } elseif ($type == 'comment_product') {
                    $type_comment = 'product';
                }
                $get_comment = new Class_CommentController();
                $result = $get_comment->action_fav_comment($link, $type_comment, $type, 'like', 1, Auth::user()->id, 0);
            }

            $num_like = $result['num_like'];
            $state_action = $result['like'];
            return response()->json(['state_action' => $state_action, 'num_like' => $num_like, 'response' => $response]);
        }
    }

//**************************************page:single comment for (news and video)***************************************************
    public function get_data_Data(Request $request) {
        if ($request->ajax()) {
            $response = $image = $audio = $content = $video = '';
            foreach ($request->input() as $key => $value) {
                $$key = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $get_commment = new Class_CommentController();
            $data_commment = $get_commment->get_commentLink($comment_link, 1);
            if (isset($data_commment->id)) {
                $response = 1;
                $content = $data_commment->content;
                $video = $data_commment->video;
                $audio = $data_commment->audio;
                $image = $data_commment->image;
            } else {
                $response = 0;
            }
            return response()->json(['response' => $response, 'image' => $image
                        , 'content' => $content, 'audio' => $audio, 'video' => $video]);
        }
    }

    public function add_post_comment(Request $request) {
        if ($request->ajax()) {
            $response = '';
            $comt_quest_count = 0;
            foreach ($request->input() as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $type = $input['type'];
            $type_comment = $input['type_comment'];
            $input['type'] = $input['type_comment'];
            $insert_commment = new Class_CommentController();
            $result_commment = $insert_commment->add_commentDATA($input, $type, $type_comment);
            $current_data = $result_commment['post'];
            $state_add = $result_commment['state_add'];
            if ($state_add == 1) {
                $get_comment = new Class_CommentController();
                $all_comment = $get_comment->get_commentdata($current_data, $type);
                $all_comment['current_data'] = $current_data;
                $comt_quest_count = $all_comment['comt_quest_count'];
                if ($type == 'product') {
                    $response = view('site.products.display_comment_Loop', $all_comment)->render();
                } else {
                    $response = view('site.layouts.display_comment_Loop', $all_comment)->render();
                }
            } else {
                $all_comment = array('wrong' => trans('app.save_failed'));
                $response = view('site.layouts.correct_wrong', $all_comment)->render();
            }
            return response()->json(['state_add' => $state_add, 'response' => $response, 'comt_quest_count' => $comt_quest_count]);
        }
    }

    public function update_post_Data(Request $request) {
        if ($request->ajax()) {
            $response = '';
            foreach ($request->input() as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $type = $input['type'];
            $type_comment = $input['type_comment'];
            $input['type'] = $input['type_comment'];
            $update_commment = new Class_CommentController();
            $result_commment = $update_commment->update_commentDATA($input, $type);
            $current_data = $result_commment['post'];
            $state_add = $result_commment['state_add'];
            if ($state_add == 1) {
                $get_comment = new Class_CommentController();
                $all_comment = $get_comment->get_commentdata($current_data, $type);
                $all_comment['current_data'] = $current_data;
                if ($type == 'product') {
                    $response = view('site.products.display_comment_Loop', $all_comment)->render();
                } else {
                    $response = view('site.layouts.display_comment_Loop', $all_comment)->render();
                }
            } else {
                $all_comment = array('wrong' => trans('app.update_failed'));
                $response = view('site.layouts.correct_wrong', $all_comment)->render();
            }
            return response()->json(['state_add' => $state_add, 'response' => $response]);
        }
    }

    public function remove_comments(Request $request) {
        if ($request->ajax()) {
            $response = '';
            $comt_quest_count = 0;
            $type = '';
            $type_comment = 'comment';
            foreach ($request->input() as $key => $value) {
                $$key = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $delete_commment = new Class_CommentController();
            $result_commment = $delete_commment->delete_commentDATA($comment_link, $type);
            $current_data = $result_commment['post'];
            $state_add = $result_commment['state_add'];
            if ($state_add == 1) {
                $get_comment = new Class_CommentController();
                $all_comment = $get_comment->get_commentdata($current_data, $type);
                $all_comment['current_data'] = $current_data;
                $comt_quest_count = $all_comment['comt_quest_count'];
                if ($type == 'product') {
                    $response = view('site.products.display_comment_Loop', $all_comment)->render();
                } else {
                    $response = view('site.layouts.display_comment_Loop', $all_comment)->render();
                }
            } else {
                $all_comment = array('wrong' => trans('app.delete_failed'));
                $response = view('site.layouts.correct_wrong', $all_comment)->render();
            }
            return response()->json(['state_add' => $state_add, 'response' => $response, 'comt_quest_count' => $comt_quest_count]);
        }
    }

//*****************not use ************************

    public function get_single_comment(Request $request) {
        if ($request->ajax()) {
            $response = 1;
            $buy = 0;
            $current_data = [];
            foreach ($request->input() as $key => $value) {
                $$key = $value; // stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            if ($type == 'news') {
                $type = 'blog';
            }
            $current_data = (object) $current_data;
            $get_comment = new Class_CommentController();
            $all_comment = $get_comment->get_commentdata($current_data, $type);
            $all_comment['current_data'] = $current_data;
            $comt_quest_count = $all_comment['comt_quest_count'];
            if ($type == 'product') {
                $response = view('site.products.display_comment_Loop', $all_comment)->render();
            } else {
                $response = view('site.layouts.display_comment_Loop', $all_comment)->render();
            }
            return response()->json(['response' => $response, 'comt_quest_count' => $comt_quest_count]);
        }
    }

    public function order_equation(Request $request) {
        if ($request->ajax()) {
            $response = $type = '';
            foreach ($request->input() as $key => $value) {
                $$key = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            //  name_order type_order myData
            $col_order = 'id';
            $valname_order = '';
            if ($name_order == 'time') {
                $col_order = 'created_at';
            } elseif ($name_order == 'num') {
                $valname_order = $name_order;
            }
            $get_course = new Class_CourseController();
            $current_data = $get_course->get_course($cou_link);
            $get_comment = new Class_CommentController();
            $all_comment = $get_comment->get_commentdata($current_data, $type, $myData, $col_order, $type_order, $name_order, $valname_order);
            $all_comment['current_data'] = $current_data;
            $response = view('site.layouts.comment_Data', $all_comment)->render();
            return response()->json(['response' => $response]);
        }
    }

}
