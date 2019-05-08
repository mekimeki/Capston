<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //

    protected $table ='reply_tb';
    protected $primaryKey = 'replay_pk';//reply_pk

    public $timestamps = false;
    protected $guarded = [];

    public function Video(){
    	return $this->belongsTo(Video::class,'video_id','video_pk');
    }

    public function replier(){
    	return $this->belongsTo(Member::class,'replier_id','member_pk');
    }

    public function parent(){
    	return $this->belongsTo(Member::class,'parent','member_pk');
    }
}
