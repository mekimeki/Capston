<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Folower extends Model
{
    //
    protected $table ='folower_tb';
    public $timestamps = false;
    protected $guarded = [];
    

    public function member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }

    public function folower(){
    	return $this->belongsTo(Member::class,'folower','member_pk');
    }

}
