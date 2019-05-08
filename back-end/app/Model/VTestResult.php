<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VTestResult extends Model
{
    //
    protected $table='votest_result_tb';
    public $timestamps = ['test_dt'];
    protected $guarded = [];
    protected $dateFormat = 'U';
    
    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
