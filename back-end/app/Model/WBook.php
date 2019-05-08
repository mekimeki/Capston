<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WBook extends Model
{
    //
    protected $table='wbook_tb';
    public $timestamps = false;
    protected $guarded = [];

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
