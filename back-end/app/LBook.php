<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LBook extends Model
{
    //
    protected $table ='LBOOK_TB';
    public $timestamps = false;
    protected $primarykey = 'LBOOK_PK';

    public function member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }

    public function LbookRecommend(){
    	return $this->hasMany(LbookRecommend::class,'lbook_id','lbook_pk');
    }
}
