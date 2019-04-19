<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MTag extends Model
{
    //
    protected $table = 'MTAG_TB';
    protected $timestamps = false;

    public function Member(){
    	return $this->belongsTo(Member::class,'member_id','member_pk');
    }

    public function Tag(){
    	return $this->belongsTo(Tag::class,'tag_id','tag_pk');
    }
}
