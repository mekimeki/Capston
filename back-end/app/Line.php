<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    //
    protected $table='line_tb';
    public $timestamps = false;

     public function LBook(){
     	return $this->belongsTo(LBook::class,'lbook_id','lbook_pk');
     }
}
