<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SResult extends Model
{
    //
    protected $table='sresult_tb';
    public $timestamps = false;
    protected $guarded = [];

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
