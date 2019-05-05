<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table ='tag_tb';
    public $timestamps = false;
    protected $guarded = [];

    public function VTag(){
    	return $this->hasMany(VTag::class,'tag_id','tag_pk');
    }

    public function MTag(){
    	return $this->hasMany(MTag::class,'tag_id','tag_pk');
    }
}
