<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    protected $table ='REPLY_TB';
    public $timestamps = false;
    protected $guarded = [];

    public function Video(){
    	return $this->belongsTo(Video::class,'video_id','video_pk');
    }
}
