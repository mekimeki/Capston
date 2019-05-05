<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ViewCNT extends Model
{
    //
    protected $table ='view_cnt_tb';
    public $timestamps = false;
    protected $guarded = [];

    public function Video(){
    	return $this->belongsTo(Video::class,'video_pk','video_pk');
    }

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
