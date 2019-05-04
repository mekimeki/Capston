<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MVOBook extends Model
{
    //
    protected $table='mvobook_tb';
    protected $timestamps = false;

    public function MVO(){
    	return $this->hasMany(MVO::class,'mvobook_pk','mvobook_pk');
    }

    public function Member(){
    	return $this->belongsTo(Member::class,'member_pk','member_pk');
    }
}
