<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VTestResult extends Model
{
    //
    protected $table='VOTEST_RESULT_TB';
    public $timestamps = false;

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
