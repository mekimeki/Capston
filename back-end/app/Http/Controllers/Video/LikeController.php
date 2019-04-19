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
use App\Model\Like;

class LikeController extends Controller
{
    //

    public function like($video_pk){
    	if(Auth::user()){
    		$like = new Like;
    		$m_id = Auth::user()->member_pk;
    		$check = $like->where('m_id',$m_id)->where('video_pk',$video_pk)->first();
    		if(!$check){
    			/*수정필요*/
    			$like->fill([
	    			'm_id'=>$m_id,
	    			'video_pk'=>$video_pk,
    			]);
    			$like->save();
    			return response()->json([
	    			'message'=>'success'
	    		],200);
    		}else{
    			return response()->json([
	    			'message'=>'already liked'
	    		],200);
    		}
    	}else{
			return response()->json([
	    		'message'=>'login please'
	    	],200);
		}
    }

    public function likeCancel($video_pk){
    	if(Auth::user()){
    		$like = new Like;
    		$m_id = Auth::user()->member_pk;
    		$check = $like->where('m_id',$m_id)->where('video_pk',$video_pk)->first();
    		if($check){
    			$like->where('m_id',$m_id)->where('video_pk',$video_pk)->delete();
    			return response()->json([
	    			'message'=>'success'
	    		],200);
    		}else{
    			return response()->json([
	    			'message'=>'you are not like this video'
	    		],200);
    		}
    		
    	}else{
			return response()->json([
	    		'message'=>'login please'
	    	],200);
		}
    }
}
