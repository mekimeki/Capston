<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MTag extends Model
{
    //
    protected $table = 'mtag_tb';
    protected $timestamps = false;
    protected $primarykey = '';
    protected $guarded = [];

    public function Member(){
    	return $this->belongsTo(Member::class,'member_id','member_pk');
    }

    public function Tag(){
    	return $this->belongsTo(Tag::class,'tag_id','tag_pk');
    }
}
