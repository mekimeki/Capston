<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    //
    protected $table ='LIKE_TB';
    protected $timestamps = false;

    public function Video(){
    	return $this->belongsTo(Video::class,'video_pk','video_pk');
    }

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
