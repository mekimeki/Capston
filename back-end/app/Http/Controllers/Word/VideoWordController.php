<?php

namespace App\Http\Controllers\Word;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VWord;

class VideoWordController extends Controller
{
    //

    public function addWord(Request $request){
        $words = $request->words;
        $words = json_decode($words);
        for($i=0 ; $i<count($words) ; $i++){
            $v_id = $words[$i]['video_pk'];
            $vw_nm = $words[$i]['word'];
            $w_exp = $words[$i]['explain'];
            $start_time = $words[$i]['start_time'];
            $end_time = $words[$i]['end_time'];
            VWord::create([
                'v_id'=>$v_id,
                'vw_nm'=>$vw_nm,
                'w_exp'=>$w_exp,
                'start_time'=>$start_time,
                'end_time'=>$end_time
            ]);
        }
    	
        return ;
    }

    public function getWord(){
        $word = VWord::where('v_id',1)->get();
        $result = array();
        for($i=0 ; $i<count($word) ; $i++ ){
            $result[$i] = [
                (string)($i+1),
                [
                    $word[$i]['start_time'],
                    $word[$i]['end_time']
                ],
                $word[$i]['w_exp']
            ];
        }
        return response()->json([
            'word'=>$result
        ]);
    }
}
