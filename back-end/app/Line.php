<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    //
    protected $table='LINE_TB';
    protected $timestamps = false;

     public function LBook(){
     	return $this->belongsTo(LBook::class,'lbook_id','lbook_pk');
     }
}
