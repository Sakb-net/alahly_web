<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Contact extends Model {

    protected $table = 'contacts';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'visitor', 'type', 'name', 'email', 'phone', 'title', 
        'content', 'attachment', 'is_read', 'is_reply'
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->attributes['created_at'] = $this->freshTimestamp();
    }

    public function contactReply() {
        return $this->hasMany(\App\Model\ContactReply::class);
    }

    public function insertContact($user_id, $visitor, $name, $email, $content, $type = 'ask', $attachment = NULL, $is_read = 0, $is_reply = 0) {
        $this->user_id = $user_id;
        $this->visitor = $visitor;
        $this->name = $name;
        $this->email = $email;
        $this->content = $content;
        $this->attachment = $attachment;
        $this->is_read = $is_read;
        $this->is_reply = $is_reply;
        $this->type = $type;
        return $this->save();
    }

    public static function updateContactColumnID($id, $column, $column_value) {
        $order = static::findOrFail($id);
        $order->$column = $column_value;
        return $order->save();
    }

    public static function updateContactColum($colum, $valueColum, $columUpdate, $valueUpdate) {
        return static::where($colum, $valueColum)->update([$columUpdate => $valueUpdate]);
    }

    public static function updateContactRead($id) {
        return static::where('id',$id)->update(['is_read' => 1]);
    }

    public static function countUnRead() {
        return static::where('is_read', 0)->count();
    }

    public static function countUnReply() {
        return static::where('is_reply', 0)->count();
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

}
