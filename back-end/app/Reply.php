<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    protected $table ='reply_tb';
    protected $timestamps = false;

    public function Video(){
    	return $this->belongsTo(Video::class,'video_id','video_pk');
    }
}
