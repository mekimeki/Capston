<?php
/**
 * 클래스명:                       LikeController
 * @package                       App\Http\Controllers\Video
 * 클래스 설명:                   구독을 하거나 취소하는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 * like(추천할 회원ID) : 추천하기
 * likeCancel(추천 취소할 회원ID) : 추천취소
 */
namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Member\CheckController;
use App\Model\Like;

class LikeController extends Controller
{
    //

    public $check;
    public function __construct(){
        $this->check = new CheckController();
    }

    public function like($video_pk,Request $request){
        $m_id = $this->check->check($request);
        if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
        }
    	$like = new Like;
    	//$likeCheck = $like->where('m_id',$m_id)->where('video_pk',$video_pk)->first();
        $likeCheck = $like->where([
            'm_id'=>$m_id,
            'video_pk'=>$video_pk
        ])->first();
    	if(!$likeCheck){
    		/*수정필요*/
    		$like->fill([
	    		'm_id'=>$m_id,
	    		'video_pk'=>$video_pk,
    		]);
    		$like->save();
    		return response()->json([
	    		'message'=>'you are like this video'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'already liked'
	    	],200);
    	}
    }

    public function likeCancel($video_pk,Request $request){
        $m_id = $this->check->check($request);
        if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
        }
    	$like = new Like;
    	$likeCheck = $like->where([
            'm_id'=>$m_id,
            'video_pk'=>$video_pk
        ])->first();
    	if($likeCheck){
    		$like->where([
                'm_id'=>$m_id,
                'video_pk'=>$video_pk
            ])->delete();
    		return response()->json([
	    		'message'=>'like cancel this video'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'you are not like this video'
	    	],200);
    	}
    		
    }
}
