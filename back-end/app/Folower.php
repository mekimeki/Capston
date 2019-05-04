<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folower extends Model
{
    //
    protected $table ='follower_tb';
    public $timestamps = false;
    

    public function member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }

    public function folower(){
    	return $this->belongsTo(Member::class,'folower','member_pk');
    }

}
