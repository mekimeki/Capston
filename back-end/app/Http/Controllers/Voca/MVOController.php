<?php
/**
 * 클래스명:                       MVOController
 * @package                       App\Http\Controllers\Voca
 * 클래스 설명:                   회원어휘집에 있는 문법 정보 관리
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 6일
 * 수정일:                        2019년 5월 7일
 * 함수 목록
 * addVoca(Request) : Request(JWT토큰(로그인 토큰),어휘집ID(mvobook_pk),문법(voca),단어(explain)) 어휘집에 새로운 문법 추가
 * deleteVoca(Request) : Request(JWT토큰(로그인 토큰),어휘집ID(mvobook_pk),문법ID(vo_pk),) 어휘집에 있는 문법 삭제
 */
namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MVO;
use App\Model\MVOBook;
use App\Model\Vocabulary;
use App\Http\Controllers\Member\CheckController;

class MVOController extends Controller
{
    //
    public $check;

    public function __construct(){
      $this->check = new CheckController();
    }

    public function addVoca(Request $request){
    	
    	$member_pk = $this->check->check($request);
       
        if(isset($member_pk[0]['messages']) ){
            return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }
        
    	$voca = $request->voca;
    	$explain = $request->explain;
    	$mvobook_pk = $request->mvobook_pk;
    	//$vocaCheck = Vocabulary::where('voca',$voca)->where('explain',$explain)->get();
    	$vocaCheck = Vocabulary::where([
    		'voca'=>$voca,
    		'explain'=>$explain
    	])->get();
    	//return count($vocaCheck);
    	if( count($vocaCheck)>0 ){
    		$vo_pk = $vocaCheck[0]['vo_pk'];
    		//$MVOCheck = MVO::where('vo_pk',$vo_pk)->where('mvobook_pk',$mvobook_pk)->get();
    		$MVOCheck = MVO::where([
    			'vo_pk'=>$vo_pk,
    			'mvobook_pk'=>$mvobook_pk
    		])->get();
    		if(isset($MVOCheck[0])){
    			return response()->json([
		    		'message'=>'Already added this voca!!'
		    	]);
    		}
    	}else{
    		$vocaCheck = Vocabulary::create([
    			'voca'=>$voca,
    			'explain'=>$explain
    		]);
    		$vo_pk = $vocaCheck->vo_pk;
    	}
    	MVO::create([
    		'mvobook_pk'=>$mvobook_pk,
    		'vo_pk'=>$vo_pk
    	]);
    	return response()->json([
    		'message'=>'added voca'
    	]);

    }

    public function deleteVoca(Request $request){
    	$member_pk = $this->check->check($request);
       
        if(isset($member_pk[0]['messages']) ){
            return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }
        $mvobook_pk = $request->mvobook_pk;
        $vo_pk = $request->vo_pk;
        $vocaBookCheck = MVOBook::where([
        	'member_pk'=>$member_pk,
        	'mvobook_pk'=>$mvobook_pk
        ])->get();
        if( isset($vocaBookCheck[0]) ){
        	MVO::where([
	        	'mvobook_pk'=>$mvobook_pk,
	        	'vo_pk'=>$vo_pk
	        ])
	        ->delete();
	        return response()->json([
	    		'message'=>'deleted voca'
	    	]);
        }else{
        	return response()->json([
	    		'message'=>'Member information does not match'
	    	]);
        }
        
    }
}
