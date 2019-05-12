<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    //
    protected $table = 'line_tb';
    public $timestamps = false;
    protected $primarykey = 'line_pk';
    protected $guarded = [];

    public function LBook()
    {
        return $this->belongsTo(LBook::class, 'lbook_id', 'lbook_pk');
    }
}
