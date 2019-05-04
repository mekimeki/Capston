<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WBookRecommend extends Model
{
    //
    protected $table='wbook_recommend_tb';
    public $timestamps = false;

    public function WBook(){
    	return  $this->belongsTo(WBook::class,'wbook_id','wbook_pk');
    }

    public function Member(){
    	return  $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
