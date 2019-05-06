<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VTestResult extends Model
{
    //
    protected $table='VOTEST_RESULT_TB';
    public $timestamps = ['test_dt'];
    protected $guarded = [];

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
