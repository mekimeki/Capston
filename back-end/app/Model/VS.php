<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VS extends Model
{
    //
    protected $table='VS_TB';
    public $timestamps = false;
    protected $guarded = [];

    public function Video(){
    	return $this->belongsTo(Video::class,'v_id','video_pk');
    }
}
