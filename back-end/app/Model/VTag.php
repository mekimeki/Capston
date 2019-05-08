<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VTag extends Model
{
    //
    protected $table='vtag_tb';
    public $timestamps = false;
    protected $guarded = [];

    public function Video(){
    	return $this->belongsTo(Video::class,'video_id','video_pk');
    }

    public function Tag(){
    	return $this->belongsTo(Tag::class,'tag_id','tag_pk');
    }
}
