<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VTag extends Model
{
    //
    protected $table='VTAG_TB';
    public $timestamps = false;

    public function Video(){
    	return $this->belongsTo(Video::class,'video_id','video_pk');
    }

    public function Tag(){
    	return $this->belongsTo(Tag::class,'tag_id','tag_pk');
    }
}
