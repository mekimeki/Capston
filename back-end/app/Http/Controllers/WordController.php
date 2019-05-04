<?php

namespace App\Http\Controllers;

use App\WBook;
use App\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Snoopy;
use Illuminate\Support\Arr;

class WordController extends Controller
{
    public function book($b_id = null)
    {
        $books = wbook::where('m_id', 1)->select('wbook_pk')->get();
        $vocas = [];

        if($b_id == false) {
            $vocas = \DB::table('word_tb')->select('w_nm', 'w_pk')->groupBy('w_nm','w_pk')->get()->toArray();

            
        } else {
            $vocas = word::where('wbook_pk', $b_id)->select('w_pk AS id', 'w_nm AS word', 'memo_st AS memorized')->get();
        }
        $vocas = json_encode($vocas, JSON_UNESCAPED_UNICODE);
        return $vocas;
    }

}
