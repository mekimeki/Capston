<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MVO extends Model
{

    protected $table='mvo_tb';
    protected $timestamps = false;

    protected $guarded = [];

    public function MVOBook(){
    	return $this->belongsTo(MVOBook::class,'mvobook_pk','mvobook_pk');
    }

    public function Vocabulary(){
    	return $this->belongsTo(Vocabulary::class,'vo_pk','vo_pk');
    }
}
