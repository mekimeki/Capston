<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table ='TAG_TB';
    public $timestamps = false;

    public function VTag(){
    	return $this->hasMany(VTag::class,'tag_id','tag_pk');
    }

    public function MTag(){
    	return $this->hasMany(MTag::class,'tag_id','tag_pk');
    }
}
