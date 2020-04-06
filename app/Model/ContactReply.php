<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model {

    protected $table = 'contact_reply';
    //public $timestamps = false;
    protected $fillable = [
        'contact_id','title','content','attachment'
    ];

    public function __construct(array $attributes = [])
    {
            parent::__construct($attributes);

            $this->attributes['created_at'] = $this->freshTimestamp();
    }
    
    public function contact() {
        return $this->belongsTo(\App\Model\Contact::class);
    }

    public function insertReply($contact_id,$title,$content,$attachment = NULL) {
        
        $this->contact_id   = $contact_id;
        $this->title        = $title;
        $this->content      = $content;
        $this->attachment   = $attachment;
        return $this->save();
        
    }

    public static function deleteReply($contact_id) {
        return static::where('contact_id', $contact_id)->delete();
    }

}
