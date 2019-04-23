<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WBook extends Model
{
    //
    protected $table='WBOOK_TB';
    public $timestamps = false;
    protected $guarded = [];

    public function Member(){
    	return $this->belongsTo(Member::class,'m_id','member_pk');
    }
}
