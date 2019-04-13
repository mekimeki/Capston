<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    //
    protected $table='WORD_TB';
    public $timestamps = false;

    public function WBook(){
    	return $this->belongsTo(WBook::class,'wbook_pk','wbook_pk');
    }
}
