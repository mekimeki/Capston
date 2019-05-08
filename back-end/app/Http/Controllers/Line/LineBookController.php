<?php
/**
 * 클래스명:                       LineBookController
 * @package                       App\Http\Controllers\Line
 * 클래스 설명:                   대사 앨범을 추가 하거나 정보를 불러올 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 * insert(대사앨범정보) : 대사앨범 추가 하기
 */
namespace App\Http\Controllers\Line;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\LBook;
use App\Http\Controllers\Member\CheckController;


class LineBookController extends Controller
{
    //

    public function __construct(){
      $this->check = new CheckController();
    }
    
    public function insert(Request $request){
    	if(Auth::user()){
    		$m_id = Auth::user()->member_pk;
    		$lineBook = new LBook;
    		$lineBook->fill([
    			'm_id'=>$m_id,
    			'lbook_tt'=>$request->lbook_tt,
    			'lbook_lan'=>$request->lbook_lan

    		]);
    		$lineBook->save();
    		return response()->json([
	    		'message'=>'success'
	    	],200);
    	}else{
			return response()->json([
	    		'status'=>'login please'
	    	],200);
		}
    }
}
