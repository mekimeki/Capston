<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    //

    protected $table='vocabulary_tb';

    protected $primaryKey = 'vo_pk';

    public $timestamps = false;
    protected $guarded = [];

    public function VG(){
    	return $this->hasMany(VG::class,'gidiom_pk','vo_pk');
    }

    public function MVO(){
    	return $this->hasMany(MVO::class,'vo_pk','vo_pk');
    }
}
