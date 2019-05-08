<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LBook extends Model
{
    //
    protected $table ='lbook_tb';
    public $timestamps = false;
    protected $primarykey = 'LBOOK_PK';
    protected $guarded = [];

    public function member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }

    public function LbookRecommend(){
    	return $this->hasMany(LbookRecommend::class,'lbook_id','lbook_pk');
    }
}
