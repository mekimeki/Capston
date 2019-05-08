<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VG extends Model
{
    //
    protected $table ='vg_tb';
    public $timestamps = false;
    protected $guarded = [];

    public function Video(){
    	return $this->belongsTo(Video::class,'video_pk','video_pk');
    }

    public function Vocabulary(){
    	return $this->belongsTo(Vocabulary::class,'gidiom_pk','vo_pk');
    }
}
