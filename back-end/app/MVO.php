<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MVO extends Model
{
    //
    protected $table='MVO_TB';
    protected $timestamps = false;

    public function MVOBook(){
    	return $this->belongsTo(MVOBook::class,'mvobook_pk','mvobook_pk');
    }

    public function Vocabulary(){
    	return $this->belongsTo(Vocabulary::class,'vo_pk','vo_pk');
    }
}
