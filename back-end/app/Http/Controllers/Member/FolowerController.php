<?php
/**
 * 클래스명:                       FolowerController
 * @package                       App\Http\Controllers\Member
 * 클래스 설명:                   구독을 하거나 취소하는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 * subscribe(구독할 회원ID) : 구독하기
 * subscribeCancel(구독 취소할 회원ID) : 구독취소
 */
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Folower;
class FolowerController extends Controller
{
    //

    public function subscribe($m_id){
    	if(Auth::user()){
    		$folower = new Folower;
    		$folower_id = Auth::user()->member_pk;
    		$check = $folower->where('m_id',$m_id)->where('folower_id',$folower_id)->first();
    		if(!$check){
    			$folower->fill([
	    			'm_id'=>$m_id,
	    			'folower_id'=>$folower_id,
    			]);
    			$folower->save();
    			return response()->json([
	    			'message'=>'success'
	    		],200);
    		}else{
    			return response()->json([
	    			'message'=>'subscribed!!!'
	    		],200);
    		}
    		
    	}else{
			return response()->json([
	    		'message'=>'login please'
	    	],200);
		}
    }

    public function subscribeCancel($m_id){
    	if(Auth::user()){
    		$folower = new Folower;
    		$folower_id = Auth::user()->member_pk;
    		$check = $folower->where('m_id',$m_id)->where('folower_id',$folower_id)->first();
    		if($check){
    			$folower->where('m_id',$m_id)->where('folower_id',$folower_id)->delete();
    			return response()->json([
	    			'message'=>'success'
	    		],200);
    		}else{
    			return response()->json([
	    			'message'=>'you are not subscribe this member'
	    		],200);
    		}
    		
    	}else{
			return response()->json([
	    		'message'=>'login please'
	    	],200);
		}
    }
}
