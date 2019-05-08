<?php
/**
 * 클래스명:                       VideoWordController
 * @package                       App\Http\Controllers\Word
 * 클래스 설명:                   영상 단어추가 및 불러오기
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * addWord(단어정보,비디오ID) :  단어 추가
 * loadWord(비디오ID) : 비디오ID로 해당 비디오와 관련된 단어 검색
 */
namespace App\Http\Controllers\Word;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\VWord;

class VideoWordController extends Controller
{
    //

    public function addWord($words,$v_id){
        for($i=0 ; $i<count($words) ; $i++){
            $vw_nm = $words[$i]['voca'];
            $w_exp = $words[$i]['explain'];
            $start_time = $words[$i]['firstTime'];
            $end_time = $words[$i]['firstTime']+2;
            VWord::create([
                'v_id'=>$v_id,
                'vw_nm'=>$vw_nm,
                'w_exp'=>$w_exp,
                'start_time'=>$start_time,
                'end_time'=>$end_time
            ]);
        }
    	
        
    }

    public function loadWord($video_pk){
        $word = VWord::where('v_id',$video_pk)->orderby('start_time','asc')->get();
        $result = array();
        for($i=0 ; $i<count($word) ; $i++ ){
            $result[$i] = [
                (string)($i+1),
                [
                    $word[$i]['start_time'],
                    $word[$i]['end_time']
                ],
                [
                    $word[$i]['vw_nm'],
                    $word[$i]['w_exp']
                ]
            ];
        }
        return $result;
        return response()->json([
            'word'=>$result
        ]);
    }
}
