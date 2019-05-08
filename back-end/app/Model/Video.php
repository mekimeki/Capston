<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Tag;
class Video extends Model
{
    //

    protected $table = 'video_tb';

    protected $primaryKey = 'video_pk';

    protected $guarded = [];
    public $timestamps = false;

    public function Member(){
        return $this->belongsTo(Member::class,'m_id','member_pk');
    }

    public function VTag(){
    	return $this->hasmany(VTag::class,'video_id','video_pk');
    }

    public function VS(){
    	return $this->hasMany(VS::class,'v_id','video_pk');
    }

    public function VG(){
    	return $this->hasMany(VG::class,'video_pk','video_pk');
    }

    public function Like(){
    	return $this->hasMany(Like::class,'video_pk','video_pk');
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
