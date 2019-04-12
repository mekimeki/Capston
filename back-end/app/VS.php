<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VS extends Model
{
    //
    protected $table='VS_TB';
    public $timestamps = false;

    public function Video(){
    	return $this->belongsTo(Video::class,'v_id','video_pk');
    }
}
