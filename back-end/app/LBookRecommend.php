<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LBookRecommend extends Model
{
    //
    protected $table='LBOOK_RECOMMEND_TB';
    protected $timestamps = false;
    
    public function lbook(){
    	return $this->belongsTo(Lbook::class,'LBOOK_ID','LBOOK_PK');
    }

    public function member(){
    	return $this->belongsTo(Member::class,'M_ID','MEMBER_PK');
    }
}
