<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VTestResult extends Model
{
    //
    protected $table='votest_result_tb';
    public $timestamps = false;

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
