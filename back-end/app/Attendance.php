<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table ='attendance_tb';
    public $timestamps =  false;

    public function Member(){
    	return $this->belongsTo(Member::class,'member_pk','member_pk');
    }
}
