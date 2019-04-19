<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VWord extends Model
{
    //
    protected $table='VWORD_TB';
    public $timestamps = false;

    public function Video(){
    	return $this->belongsTo(Video::class,'v_id','video_pk');
    }
}
