<?php

namespace App\Http\Controllers\ClassSiteApi;

use Illuminate\Http\Request;
use \Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Model\Product;
use App\Model\CommentProduct;
use App\Model\Video;
use App\Model\CommentVideo;
use App\Model\Blog;
use App\Model\CommentBlog;
use App\Model\Comment;
use App\Model\Action;
use App\Model\Options;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClassSiteApi\Class_ActionController;
use App\Http\Controllers\ClassSiteApi\Class_NotifController;

class Class_CommentController extends SiteController {

    public function __construct() {
        $data_site = Options::Site_Option();
        $this->site_open = $data_site['site_open'];
        $this->lang = $data_site['lang'];
        $this->site_title = $data_site['site_title'];
        $this->site_url = $data_site['site_url'];
        $this->current_id = 0;
        if (!empty(Auth::user())) {
            $this->current_id = Auth::user()->id;
            $this->user_key = Auth::user()->name;
        }
    }

    public function get_data($link, $type = 'blog', $user_id = 0, $api = 0, $num_state = 1) {
        $lang = $this->lang;
        $current_id = $this->current_id;
        if ($type == 'video' && $num_state == 1) {
            $data = Video::get_DataType($link, 'link', $type, 1, $user_id);
        } elseif ($type == 'video' && $num_state == 2) { //id
            $data = Video::get_DataType($link, 'id', $type, 1, $user_id);
        } elseif ($type == 'blog' && $num_state == 1) {
            $data = Blog::get_DataType($link, 'link', $type, 1, $user_id);
        } elseif ($type == 'blog' && $num_state == 2) { //id
            $data = Blog::get_DataType($link, 'id', $type, 1, $user_id);
        } elseif ($type == 'product' && $num_state == 1) {
            $data = Product::get_DataType($link, 'link', $type, 1, $user_id);
        } elseif ($type == 'product' && $num_state == 2) { //id
            $data = Product::get_DataType($link, 'id', $type, 1, $user_id);
        }
        return $data;
    }

    public function get_dataComment($link, $type = 'blog', $is_active = 1, $api = 0) {
        $lang = $this->lang;
        $current_id = $this->current_id;
        if ($type == 'video') {
            $data = CommentVideo::commentLink('link', $link, $is_active);
        } elseif ($type == 'product') {
            $data = CommentProduct::commentLink('link', $link, $is_active);
        } elseif ($type == 'blog') {
            $data = CommentBlog::commentLink('link', $link, $is_active);
        } else {
            $data = Comment::commentLink('link', $link, $is_active);
        }
        return $data;
    }

    public function get_commentLink($comment_link, $is_active = 1) {
        $lang = $this->lang;
        $current_id = $this->current_id;
        $comment = Comment::commentLink('link', $comment_link, $is_active);
        return $comment;
    }

    public function add_delete_fav_comment($comment, $type = 'comment', $type_action = 'like', $current_id = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
        }
        $check_fav = new Class_ActionController();
        $state_fav = $check_fav->Check_fav_course($comment->id, $type, $type_action, $current_id, $api);
        if ($state_fav == 0) {
            $add_fav = Action::insertAction($current_id, $comment->id, $type, $type_action);
            $like = 1;
        } else {
            $delete_fav = Action::deleteUserAction($current_id, $comment->id, $type, $type_action);
            $like = 0;
        }
        return $like;
    }

    public function action_fav_comment($comment_link, $type_comment, $type, $type_action = 'like', $is_active = 1, $current_id = 0, $api = 0) {
        $lang = $this->lang;
        if (empty($lang) || $api == 1) {
            $lang = 'ar';
        }
        $get_comment = new Class_CommentController();
        $comment = $get_comment->get_dataComment($comment_link, $type_comment, $is_active, $api);
        $array_data['like'] = -1;
        $array_data['num_like'] = 0;
        if (isset($comment->id)) {
            $array_data['like'] = $get_comment->add_delete_fav_comment($comment, $type, $type_action, $current_id, $api);
            $array_data['num_like'] = Action::get_DataAction($comment->id, $type, $type_action, 1);
        }
        if ($api == 1) {
            $array_data['like'] = (string) $array_data['like'];
            $array_data['num_like'] = (string) $array_data['num_like'];
        }
        return $array_data;
    }

    public function get_commentdata($data, $type, $mydata = '', $col_order = 'id', $type_order = 'DESC', $name_order = '', $valname_order = '', $current_id = 0, $api = 0, $limit = 10, $type_comment = 'comment') {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
            $user_key = $this->user_key;
            $limit = $this->limit;
        } else {
            $lang = 'ar';
        }
        $data_node = 1;
        if ($mydata == 'yes' || $mydata == 1) {
            $valmydata = $current_id;
        } else {
            $valmydata = '';
        }
        if (isset($data->id)) {
            $current_data_id = $data->id;
        } else {
            $current_data_id = null;
        }
        $get_comment = new Class_CommentController();
        if ($type == 'video') {
            $data_comments = CommentVideo::commentTypeACtive($current_data_id, $type_comment, 1, $limit, 'parent_two_id', NULL, $valmydata, $col_order, $type_order, $valname_order);
            $comt_quest_count = CommentVideo::commentTypeACtive($current_data_id, $type_comment, 1, -1);
        } elseif ($type == 'product') {
            $data_comments = CommentProduct::commentTypeACtive($current_data_id, $type_comment, 1, $limit, 'parent_two_id', NULL, $valmydata, $col_order, $type_order, $valname_order);
            $comt_quest_count = CommentProduct::commentTypeACtive($current_data_id, $type_comment, 1, -1);
        } elseif ($type == 'blog') {
            $data_comments = CommentBlog::commentTypeACtive($current_data_id, $type_comment, 1, $limit, 'parent_two_id', NULL, $valmydata, $col_order, $type_order, $valname_order);
            $comt_quest_count = CommentBlog::commentTypeACtive($current_data_id, $type_comment, 1, -1);
        } else {
            $data_comments = Comment::commentTypeACtive($current_data_id, $type_comment, 1, $limit, 'parent_two_id', NULL, $valmydata, $col_order, $type_order, $valname_order);
            $comt_quest_count = Comment::commentTypeACtive($current_data_id, $type_comment, 1, -1);
        }
        $comment_data = $get_comment->getSelect_commentDATA_Twolevel($data_comments, $type, $current_id, $api);
//        $comment_data = $get_comment->getSelect_commentDATA($data_comments, $current_id, $api); //get all data in one level
        if ($api == 1) {
            return array('comt_quest_count' => (string) $comt_quest_count, 'comments' => $comment_data);
        } else {
            return array('data_node' => $data_node, 'current_id' => $current_id, 'user_key' => $user_key,
                'type_order' => $type_order, 'name_order' => $name_order, 'mydata' => $mydata,
                'type_comment' => $type_comment, 'type' => $type, 'data' => $data, 'comments' => $comment_data, 'comt_quest_count' => $comt_quest_count
            );
        }
    }

    public function add_commentDATA($input, $type, $type_comment, $post = [], $current_id = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
            $current_user = Auth::user();
            $get_data = new Class_CommentController();
            $post = $get_data->get_data($input['link'], $type, 0, 1);
            $name_colum = 'link';
        } else {
            $current_user = User::userData($current_id);
            $name_colum = 'link';
        }
        $state_add = 0;
        $comment=[];
        if (isset($post->id)) {
            if (isset($current_user->id)) {
                $input['user_id'] = $current_user->id;
                $input['email'] = $current_user->email;
                $input['name'] = $current_user->display_name;
                $input['user_image'] = $current_user->image;
            } else {
                $input['user_id'] = NULL;
                $input['user_image'] = generateDefaultImage($input['name']);
            }
            if ($type == 'blog') {
                $input['blog_id'] = $post->id;
                $parent_comment = CommentBlog::commentParentOneTwo($name_colum, $input['link_parent'], 1);
            } elseif ($type == 'video') {
                $input['video_id'] = $post->id;
                $parent_comment = CommentVideo::commentParentOneTwo($name_colum, $input['link_parent'], 1);
            } elseif ($type == 'product') {
                $input['product_id'] = $post->id;
                $parent_comment = CommentProduct::commentParentOneTwo($name_colum, $input['link_parent'], 1);
            } else {
                $input['post_id'] = $post->id;
                $parent_comment = Comment::commentParentOneTwo($name_colum, $input['link_parent'], 1);
            }
            if ($type == 'product') {
                if ($input['rate'] > 5) {
                    $input['rate'] = 5;
                } elseif ($input['rate'] <= 0) {
                    $input['rate'] = 0;
                }
            } else {
                unset($input['rate']);
            }
            $input['type'] = $type_comment;
            $input['parent_one_id'] = $parent_comment['parent_one_id'];
            $input['parent_two_id'] = $parent_comment['parent_two_id'];
            $input['link'] = str_replace(' ', '_', $post->name . time()); // str_random(8)
            if (empty($input['image'])) {
                $input['image'] = NULL;
            }
            if ($api == 0) {
                if (empty($input['video'])) {
                    $input['video'] = NULL;
                }
                if (empty($input['audio'])) {
                    $input['audio'] = NULL;
                }
            }
            if ($type == 'blog') {
                $comment = CommentBlog::create($input);
            } elseif ($type == 'video') {
                $comment = CommentVideo::create($input);
            } elseif ($type == 'product') {
                $comment = CommentProduct::create($input);
            } else {
                $comment = Comment::create($input);
            }
            if (isset($comment['id'])) {
                $state_add = 1;
//                $add_notif = new Class_NotifController();
//                $insert_notif = $add_notif->insert_NotificationTableComment($type,$type_comment, $post, $comment, $current_id, $api);
            }
        }
        return array('post' => $post, 'state_add' => $state_add,'comment'=>$comment);
    }

    public function update_commentDATA($input, $type, $current_id = 0, $api = 0) {
        if ($api == 0) {
            $lang = $this->lang;
            $current_id = $this->current_id;
            $current_user = Auth::user();
            $name_colum = 'link';
            $get_data = new Class_CommentController();
            $post = $get_data->get_data($input['link'], $type, 0, 1);
        } else {
            $current_user = User::userData($current_id);
            $name_colum = 'link';
        }
        if ($type == 'blog') {
            $comment = CommentBlog::commentLink($name_colum, $input['comment_link'], 1);
        } elseif ($type == 'video') {
            $comment = CommentVideo::commentLink($name_colum, $input['comment_link'], 1);
        } elseif ($type == 'product') {
            $comment = CommentProduct::commentLink($name_colum, $input['comment_link'], 1);
        } else {
            $comment = Comment::commentLink($name_colum, $input['comment_link'], 1);
        }
        $state_add = 0;
        if (isset($comment->id) && $comment->user_id == $current_id) {
            if ($type == 'product') {
                if ($input['rate'] > 5) {
                    $input['rate'] = 5;
                } elseif ($input['rate'] <= 0) {
                    $input['rate'] = 0;
                }
            } else {
                unset($input['rate']);
            }
            if (isset($current_user->id)) {
                $input['user_id'] = $current_user->id;
                $input['email'] = $current_user->email;
                $input['name'] = $current_user->display_name;
                $input['user_image'] = $current_user->image;
            } else {
                $input['user_id'] = NULL;
                $input['user_image'] = generateDefaultImage($input['name']);
            }
//            if (!empty($input['image']) && $comment->image != $input['image']) {
//                cpanelData::Compress_Image($input['image'], 'DATA');
//            }
            $update_comment = $comment->update($input);
            if ($update_comment) {
                $state_add = 1;
            }
        }
        if ($api == 0) {
            return array('post' => $post, 'state_add' => $state_add);
        } else {
            return $state_add;
        }
    }

    public function delete_commentDATA($link_comment, $type, $api = 0, $current_id = 0) {
        if ($api == 0) {
            $current_id = $this->current_id;
        }
        $state_add = 0;
        if ($type == 'blog') {
            $comment = CommentBlog::commentLink('link', $link_comment, 1);
        } elseif ($type == 'video') {
            $comment = CommentVideo::commentLink('link', $link_comment, 1);
        } elseif ($type == 'product') {
            $comment = CommentProduct::commentLink('link', $link_comment, 1);
        } else {
            $comment = Comment::commentLink('link', $link_comment, 1);
        }
        $post = [];
        if (isset($comment->id) && $comment->user_id == $current_id) {
            if ($type == 'blog') {
                $comment_table_id = $comment->blog_id;
                $delete_comment = CommentBlog::deleteDataTable('link', $link_comment);
            } elseif ($type == 'video') {
                $comment_table_id = $comment->video_id;
                $delete_comment = CommentVideo::deleteDataTable('link', $link_comment);
            } elseif ($type == 'product') {
                $comment_table_id = $comment->product_id;
                $delete_comment = CommentProduct::deleteDataTable('link', $link_comment);
            } else {
                $comment_table_id = $comment->post_id;
                $delete_comment = Comment::deleteDataTable('link', $link_comment);
            }
//            $delete_comment = $comment->delete();
//if ($delete_comment) {
            $state_add = 1;
//}
            $get_data = new Class_CommentController();
            $post = $get_data->get_data($comment_table_id, $type, 0, 1, 2);
        }
        return array('post' => $post, 'state_add' => $state_add);
    }

//**************************************************************************

    public function User_commentDATA($val_comment) {
        $array_data = [];
        if (isset($val_comment->id)) {
            $array_data['parent_id'] = $val_comment->id;
            $array_data['parent_user_name'] = $val_comment->name;
            $array_data['parent_user_image'] = $val_comment->user_image;
            if (($val_comment->user_id > 0) && isset($val_comment->user->display_name)) {
                $array_data['parent_user_name'] = $val_comment->user->display_name;
                $array_data['parent_user_image'] = $val_comment->user->image;
            }
            if (empty($array_data['parent_user_image'])) {
                $array_data['parent_user_image'] = '/images/user.png';
            }
        }
        return $array_data;
    }

    public function getSelect_commentDATA($comments, $current_id = 0, $api = 0, $all_data = [], $parent_comment = []) {
        $get_comment = new Class_CommentController();
        $get_action = new Class_ActionController();
        foreach ($comments as $key => $val_comment) {
            if ($val_comment->parent_two_id == Null && $val_comment->parent_one_id == Null) {
                $parent_comment = $val_comment;
            } else {
                $parent_comment = $val_comment->childrensID;
            }
            $array_data = $get_comment->User_commentDATA($parent_comment);
            if ($val_comment->parent_two_id > 0) {
                $array_data['replay_id'] = $val_comment->id;
                $array_data['replay_user'] = $val_comment->state_hiden;
                $array_data['replay_user_name'] = $val_comment->name;
                $array_data['replay_user_image'] = $val_comment->user_image;
                if (($val_comment->user_id > 0) && isset($val_comment->user->display_name)) {
                    $array_data['replay_user_name'] = $val_comment->user->display_name;
                    $array_data['replay_user_image'] = $val_comment->user->image;
                }
                if (empty($array_data['replay_user_image'])) {
                    $array_data['replay_user_image'] = '/images/user.png';
                }
            }
            $array_data['content'] = generateFilterEmoji($val_comment->content);
            $array_data['image'] = $val_comment->image;
            $array_data['video'] = $val_comment->video;
            $array_data['audio'] = null;
            if (!empty($val_comment->audio)) {
                $array_data['audio'] = $val_comment->audio;
            }
            if ($api == 1) {
                $array_data['owner_data'] = "0";
                $array_data['like'] = false;
                $array_Valdata['num_like'] = "0";
                if ($current_id > 0) {
                    if ($current_id == $val_comment->user_id) {
                        $array_data['owner_data'] = "1";
                    }
                    $state_fav = $get_action->Check_fav_course($val_comment->id, $val_comment->type, 'like', $current_id, $api);
                    if ($state_fav > 0) {
                        $array_data['like'] = true;
                    }
                }
                $array_data['num_like'] = (string) $get_action->get_fav_course($val_comment->id, $val_comment->type, 'like', 1, $api);
            } else {
                $array_data['user_id'] = $val_comment->user_id;
                $array_data['parent_one_id'] = $val_comment->parent_one_id;
                $array_data['state_hiden'] = $val_comment->state_hiden;
            }
            $array_data['created_at'] = $val_comment->created_at;
            $array_data['link'] = $val_comment->link;
            $all_data[] = $array_data;
            if (count($val_comment->childrenstwo) > 0) {
                $all_data = $get_comment->getSelect_commentDATA($val_comment->childrenstwo, $current_id, $api, $all_data, $parent_comment);
            }
        }
        return $all_data;
    }

    public function getSelect_commentDATA_Twolevel($comments, $type, $current_id = 0, $api = 0, $all_data = [], $parent_comment = []) {
        $lang = 'ar';
        $type_like = 'comment_' . $type;
        $get_comment = new Class_CommentController();
        $get_action = new Class_ActionController();
        foreach ($comments as $key => $val_comment) {
            if ($val_comment->parent_two_id == Null && $val_comment->parent_one_id == Null) {
                $parent_comment = $val_comment;
                $array_data = $get_comment->User_commentDATA($parent_comment);
                $array_data['content'] = generateFilterEmoji($val_comment->content);
                $array_data['image'] = $val_comment->image;
                $array_data['video'] = $val_comment->video;
                $array_data['audio'] = null;
                if (!empty($val_comment->audio)) {
                    $array_data['audio'] = $val_comment->audio;
                }
                $array_data['like'] = false;
                $array_Valdata['num_like'] = "0";
                if ($current_id > 0) {
                    $state_fav = $get_action->Check_fav_course($val_comment->id, $type_like, 'like', $current_id, $api);
                    if ($state_fav > 0) {
                        $array_data['like'] = true;
                    }
                }
                $array_data['num_like'] = (string) $get_action->get_fav_course($val_comment->id, $type_like, 'like', 1, $api);

                $array_data['owner_data'] = "0";
                if ($current_id > 0) {
                    if ($current_id == $val_comment->user_id) {
                        $array_data['owner_data'] = "1";
                    }
                }
                $array_data['star_rate'] = 0;
                if (isset($val_comment->rate)) {
                    $array_data['star_rate'] = $val_comment->rate;
                }
                if ($api == 1) {
                    $array_data['date'] = $val_comment->created_at->format('Y-m-d');
                } else {
                    $array_data['date'] = Time_Elapsed_String('@' . strtotime($val_comment->created_at), $lang);
                    $array_data['user_id'] = $val_comment->user_id;
                    $array_data['parent_one_id'] = $val_comment->parent_one_id;
                    $array_data['state_hiden'] = $val_comment->state_hiden;
                }
                $array_data['created_at'] = $val_comment->created_at;
                $array_data['link'] = $val_comment->link;
                $array_data['child_comments'] = [];
                if (count($val_comment->childrenstwo) > 0) {
                    $array_data['child_comments'] = $get_comment->data_commentDATA_Twolevel($val_comment->childrenstwo, $type_like, $current_id, $api, [], $parent_comment, $lang);
                }
                $all_data[] = $array_data;
            }
        }
        return $all_data;
    }

    public function data_commentDATA_Twolevel($comments, $type_like = 'comment', $current_id = 0, $api = 0, $all_data = [], $parent_comment = [], $lang = 'ar') {
        $get_comment = new Class_CommentController();
        $get_action = new Class_ActionController();
        foreach ($comments as $key => $val_comment) {
            if ($val_comment->parent_two_id == Null && $val_comment->parent_one_id == Null) {
                $parent_comment = $val_comment;
            } else {
                $parent_comment = $val_comment->childrensID;
            }
            $array_data = $get_comment->User_commentDATA($parent_comment);
            if ($val_comment->parent_two_id > 0) {
                $array_data['replay_id'] = $val_comment->id;
                $array_data['replay_user'] = $val_comment->state_hiden;
                $array_data['replay_user_name'] = $val_comment->name;
                $array_data['replay_user_image'] = $val_comment->user_image;
                if ($val_comment->user_id > 0) {
                    $array_data['replay_user_name'] = $val_comment->user->display_name;
                    $array_data['replay_user_image'] = $val_comment->user->image;
                }
                if (empty($array_data['replay_user_image'])) {
                    $array_data['replay_user_image'] = '/images/user.png';
                }
            }
            $array_data['content'] = generateFilterEmoji($val_comment->content);
            $array_data['image'] = $val_comment->image;
            $array_data['video'] = $val_comment->video;
            $array_data['audio'] = null;
            if (!empty($val_comment->audio)) {
                $array_data['audio'] = $val_comment->audio;
//                    $array_data['audio'] = 'https://s3.eu-central-1.amazonaws.com/baims/' . $val_comment->audio;
            }
            $array_data['like'] = false;
            $array_Valdata['num_like'] = "0";
            if ($current_id > 0) {
                $state_fav = $get_action->Check_fav_course($val_comment->id, $type_like, 'like', $current_id, $api);
                if ($state_fav > 0) {
                    $array_data['like'] = true;
                }
            }
            $array_data['num_like'] = (string) $get_action->get_fav_course($val_comment->id, $type_like, 'like', 1, $api);
            $array_data['owner_data'] = "0";
            if ($current_id > 0) {
                if ($current_id == $val_comment->user_id) {
                    $array_data['owner_data'] = "1";
                }
            }
            $array_data['star_rate'] = 0;
            if (isset($val_comment->rate)) {
                $array_data['star_rate'] = $val_comment->rate;
            }
            if ($api == 1) {
                $array_data['date'] = $val_comment->created_at->format('Y-m-d');
            } else {
                $array_data['date'] = Time_Elapsed_String('@' . strtotime($val_comment->created_at), $lang);
                $array_data['user_id'] = $val_comment->user_id;
                $array_data['parent_one_id'] = $val_comment->parent_one_id;
                $array_data['state_hiden'] = $val_comment->state_hiden;
            }
            $array_data['created_at'] = $val_comment->created_at;
            $array_data['link'] = $val_comment->link;
            $all_data[] = $array_data;
            if (count($val_comment->childrenstwo) > 0) {
                $all_data = $get_comment->data_commentDATA_Twolevel($val_comment->childrenstwo, $type_like, $current_id, $api, $all_data, $parent_comment, $lang);
            }
        }
        return $all_data;
    }

}
