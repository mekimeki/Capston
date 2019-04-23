<?php
/**
 * 클래스명:                       LineBookRecommendController
 * @package                       App\Http\Controllers\Line
 * 클래스 설명:                   원하는 대사앨범을 추천하는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 * recommend(대사앨범정보) : 대사앨 범추 천하기
 */
namespace App\Http\Controllers\Line;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\LBookRecommend;
use Illuminate\Support\Facades\Auth;
use App\Model\LBook;
use App\Model\Member;

class LineBookRecommendController extends Controller
{
    //
    public function recommend(Request $request){
    	if(Auth::user()){
    		$m_id = Auth::user()->member_pk;
    		$recommend = new LBookRecommend;
    		/*밑에 추가 바람*/
    	}else{
			return response()->json([
	    		'status'=>'login please'
	    	],200);
		}
    }
}
