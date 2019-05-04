<?php
/**
 * 클래스명:                       MemberVocaBookController
 * @package                       App\Http\Controllers\Voca
 * 클래스 설명:                   어휘장(수전체적인 수정및 삭제여부가 큼)
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 */
namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MVOBook;
use App\Model\VG;

class MemberVocaBookController extends Controller
{
    //

    public function addVocaBook(Request $request){
    	if(Auth::user()){
    		$vocaBook = new MVOBook;
    		$vocaBook->fill([
    			'member_pk'=>Auth::user()->member_pk,
    			'title'=>$request->title,
    		]);
    		$vocaBook->save();
    		return response()->json([
	    		'message'=>'add new voca book!!'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'login please!!'
	    	],200);
    	}
    }

    public function updateVocaBook(Request $request,$mvobook_pk){
    	if(Auth::user()){
    		$vocaBook = new MVOBook;
    		$vocaBook->where('mvobook_pk',$mvobook_pk)->update(['title'=>$request->title]);
    		return response()->json([
	    		'message'=>'update voca book!!'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'login please!!'
	    	],200);
    	}
    }

    public function deleteVocaBook($mvobook_pk){
    	if(Auth::user()){
    		$vocaBook = new MVOBook;
    		$vocaBook->where('mvobook_pk',$mvobook_pk)->delete();
    		return response()->json([
	    		'message'=>'success delete voca book!!'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'login please!!'
	    	],200);
    	}
    }
}
