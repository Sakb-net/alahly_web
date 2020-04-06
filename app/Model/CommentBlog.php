<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;
use App\Model\UserNotif;
use App\Model\Action;
class CommentBlog extends Model {

    protected $table = 'blog_comments';
    protected $fillable = [
        'user_id', 'blog_id', 'parent_one_id', 'parent_two_id',
        'user_image', 'name', 'email', 'type', 'content',
        'is_read', 'is_active', 'link', 'image', 'video', 'audio'
    ];
    public function user() {
        return $this->belongsTo(\App\User::class,'user_id');
    }
    public function blogs() {
        return $this->belongsTo(\App\Model\Post::class,'blog_id');
    }

    public function commentable() {
        return $this->morphTo();
    }

    public function actions() {
        return $this->morphMany(\App\Model\Action::class, 'actionable');
    }

    public function commentMeta() {
        return $this->hasMany(\App\Model\CommentMeta::class);
    }

    public function parentOneID() {
        return $this->hasMany(\App\Model\CommentBlog::class, 'parent_one_id');
    }

    public function childrenstwo() {
        return $this->hasMany(\App\Model\CommentBlog::class, 'parent_two_id');
    }

    public function parentID() {
        return $this->belongsTo(\App\Model\CommentBlog::class, 'parent_one_id');
    }

    public function childrensID() {
        return $this->belongsTo(\App\Model\CommentBlog::class, 'parent_two_id');
    }

    public static function updateCommentUser($id, $user_id, $name, $email) {
        $comment = static::findOrFail($id);
        $comment->user_id = $user_id;
        $comment->name = $name;
        $comment->email = $email;
        return $comment->save();
    }

    public static function updateOrderColumnID($id, $column, $column_value) {
        $order = static::findOrFail($id);
        $order->$column = $column_value;
        return $order->save();
    }

    public static function updateOrderColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }
    public static function deleteDataTable($col, $col_val) {
        $comments = static::where($col, $col_val)->get();
        foreach ($comments as $key => $comment) {
            static::deleteCommentParent('parent_two_id', $comment->id, $comment);
        }
        return static::where($col, $col_val)->delete();
    }

    public static function deleteCommentParent($col, $col_val, $data_comment) {
        User::DeleteImageAWs($data_comment->image);
        User::DeleteImageAWs($data_comment->video);
        User::DeleteImageAWs($data_comment->audio);
        $comments = static::where($col, $col_val)->get();
        if (count($comments) > 0) {
            foreach ($comments as $key => $comment) {
                if (isset($comment->id)) {
                    static::deleteCommentParent('parent_two_id', $comment->id, $comment);
                    UserNotif::deleteDataTableNotif($comment->id, $comment->type);
                    Action::deleteAction($comment->id, $comment->type, 'like');
                    static::where('id', $comment->id)->delete();
                }
            }
        } else {
            UserNotif::deleteDataTableNotif($data_comment->id, $data_comment->type);
            Action::deleteAction($data_comment->id, $data_comment->type, 'like');
            static::where($col, $col_val)->delete();
            static::where('id', $col_val)->delete();
        }
        return true;
    }

    public static function commentLink($colum = 'link', $val_colum = '', $is_active = 1, $type = '') {
        $data = static::with('blogs')->where($colum, $val_colum)->where('is_active', $is_active);
        if (!empty($type)) {
            $result = $data->where('type', $type);
        }
        $result = $data->first();
        return $result;
    }

    public static function commentParent($parent_one_id, $parent_two_id, $is_active = 1, $type = '') {
        $data = static::where('parent_one_id', $parent_one_id)->where('parent_two_id', $parent_two_id)->where('is_active', $is_active);
        if (!empty($type)) {
            $result = $data->where('type', $type);
        }
        $result = $data->first();
        return $result;
    }

    public static function commentParentOneTwo($name_colum='link',$val_colum='', $is_active = 1, $type = '') {
        if (!empty($val_colum)) {
            $parent_comment = static::commentLink($name_colum, $val_colum, $is_active, $type);
            if (isset($parent_comment->id)) {
                if ($parent_comment->parent_one_id == NULL || empty($parent_comment->parent_one_id)) {
                    $input['parent_one_id'] = $input['parent_two_id'] = $parent_comment->id;
                } else {
                    $input['parent_one_id'] = $parent_comment->parent_one_id;
                    $input['parent_two_id'] = $parent_comment->id;
                }
            } else {
                $input['parent_one_id'] = $input['parent_two_id'] = NULL;
            }
        } else {
            $input['parent_one_id'] = $input['parent_two_id'] = NULL;
        }

        return $input;
    }

    public static function commentTypeACtive($blog_id, $type = 'comment', $is_active = 1, $limit = 0, $colum = '', $val_colum = NULL, $myquestion = '', $colum_order = 'id', $type_order = 'DESC', $name_order = '') {
        //, 'childrenstwo.grandchildrentwo'
        $data = static::with('childrenstwo')->where('blog_id', $blog_id)->where('type', $type)->where('is_active', $is_active);
        if (!empty($myquestion)) {
            $result = $data->where('user_id', $myquestion);
        }
        if (!empty($colum)) {
            $result = $data->where($colum, $val_colum);
        }
        if (!empty($colum_order)) {
            if (!empty($name_order)) {
                $result = $data->withCount('parentOneID')->orderBy('id', $type_order);
//                $result = $data->withCount('parentOneID')->orderBy('parent_one_id',$type_order);
            } else {
                $result = $data->orderBy($colum_order, $type_order);
            }
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->count();
        } elseif ($limit == 0) {
            $result = $data->get();
        }
        return $result;
    }

    public static function SearchComment($search, $is_active = '', $limit = 0) {
        $data = static::Where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%')
                ->orWhere('blog_id', 'like', '%' . $search . '%')
                ->orWhere('link', 'like', '%' . $search . '%')
                ->orWhere('user_id', 'like', '%' . $search . '%')
                ->orWhere('user_image', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->orWhere('image', 'like', '%' . $search . '%')
                ->orWhere('video', 'like', '%' . $search . '%')
                ->orWhere('audio', 'like', '%' . $search . '%');

        if (!empty($is_active)) {
            $result = $data->where('is_active', $is_active);
        }
        if ($limit > 0) {
            $result = $data->paginate($limit);
        } elseif ($limit == -1) {
            $result = $data->pluck('id', 'id')->toArray();
        } else {
            $result = $data->get();
        }
        return $result;
    }

    public static function countUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countChild($parent_one_id) {
        return static::where('parent_one_id', $parent_one_id)->where('is_active', 1)->count();
    }

    public static function lastMonth($month, $date) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$month, $date])->get();
        return $count[0]->count;
    }

    public static function lastWeek($week, $date) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$week, $date])->get();
        return $count[0]->count;
    }

    public static function lastDay($day, $date) {

        $count = static::select(DB::raw('COUNT(*)  count'))->whereBetween(DB::raw('created_at'), [$day, $date])->get();
        return $count[0]->count;
    }

    //***************************************

    public function insertComment($user_id, $user_image, $name, $email, $blog_id, $type, $content, $parent_one_id = null, $image = "", $is_read = 0, $is_active = 0, $link = '',$parent_two_id= null) {

        $this->user_id = $user_id;
        $this->user_image = $user_image;
        $this->name = $name;
        $this->email = $email;
        $this->blog_id = $blog_id;
        $this->type = $type;
        $this->content = $content;
        $this->parent_one_id = $parent_one_id;
        $this->parent_two_id = $parent_two_id;
        $this->image = $image;
        $this->is_read = $is_read;
        $this->is_active = $is_active;
        $this->link = $link;
        return $this->save();
    }

}
