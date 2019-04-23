<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $primaryKey = 'member_pk';
    protected $table = 'member_tb';
    public $timestamps = false;
    protected $hidden = ['password'];
    protected $guarded = [];




    public function Attendance(){
        return $this->hasMany(Attendance::class,'member_pk','member_pk');
    }

    public function SResult(){
        return $this->hasMany(SResult::class,'m_id','member_pk');
    }

    public function LBook(){
        return $this->hasMany(LBook::class,'m_id','member_pk');
    }

    public function VTestResult(){
        return $this->hasMany(VTestResult::class,'m_id','member_pk');
    }

    public function WBook(){
        return $this->hasMany(WBook::class,'m_id','member_pk');
    }

    public function Folower(){
        return $this->hasMany(Folower::class,'folower_id','member_pk');
    }

    public function LBookRecommend(){
        return $this->hasMany(LBookRecommend::class,'m_id','member_pk');
    }

    public function WBookRecommend(){
        return $this->hasMany(WBookRecommend::class,'m_id','member_pk');
    }

    public function MVOBook(){
        return $this->hasMany(MVOBook::class,'member_pk','member_pk');
    }

    public function MTag(){
        return $this->hasMany(MTag::class,'member_id','member_pk');
    }

    public function Video(){
        return $this->hasMany(Video::class,'m_id','member_pk');
    }

    public function Like(){
        return $this->hasMany(Like::class,'member_id','member_pk');
    }

    public function ViewCNT(){
        return $this->hasMany(Like::class,'member_id','member_pk');
    }

    public function Report(){
        return $this->hasMany(Report::class,'m_id','member_pk');
    }
    
}
