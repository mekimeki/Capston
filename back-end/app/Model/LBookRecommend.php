<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LBookRecommend extends Model
{
    //
    protected $table='lbook_recommend_tb';
    protected $timestamps = false;
    protected $guarded = [];
    
    public function lbook(){
    	return $this->belongsTo(Lbook::class,'LBOOK_ID','LBOOK_PK');
    }

    public function member(){
    	return $this->belongsTo(Member::class,'M_ID','MEMBER_PK');
    }
}
