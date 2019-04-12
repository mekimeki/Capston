<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SResult extends Model
{
    //
    protected $table='sresult_tb';
    public $timestamps = false;

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
