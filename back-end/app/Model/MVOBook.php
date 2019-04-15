<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MVOBook extends Model
{
    //
    protected $table='MVOBOOK_TB';
    public $timestamps = false;
    protected $guarded = [];

    public function MVO(){
    	return $this->hasMany(MVO::class,'mvobook_pk','mvobook_pk');
    }

    public function Member(){
    	return $this->belongsTo(Member::class,'member_pk','member_pk');
    }
}
