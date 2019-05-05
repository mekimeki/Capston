<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    //
    protected $table='line_tb';
    protected $timestamps = false;
    protected $guarded = [];

     public function LBook(){
     	return $this->belongsTo(LBook::class,'lbook_id','lbook_pk');
     }
}
