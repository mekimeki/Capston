<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $table = 'video_tb';
    protected $guarded = [];
    public $timestamps = false;

    public function Member(){
        return $this->belongsTo(Member::class,'m_id','member_pk');
    }

    public function VTag(){
    	return $this->hasmany(VTag::class,'vdieo_id','video_pk');
    }

    public function VS(){
    	return $this->hasMany(VS::class,'vdieo_id','video_pk');
    }

    public function VG(){
    	return $this->hasMany(VG::class,'video_pk','video_pk');
    }

    public function Like(){
    	return $this->hasMany(VG::class,'video_pk','video_pk');
    }

    public function ViewCNT(){
    	return $this->hasMany(ViewCNT::class,'video_pk','video_pk');
    }

    public function Report(){
    	return $this->hasMany(Report::class,'video_pk','video_pk');
    }

    public function Reply(){
    	return $this->hasMany(Reply::class,'video_id','video_pk');
    }

    public function VWord(){
    	return $this->hasMany(VWord::class,'v_id','video_pk');
    }


}
