<?php
/**
 * 클래스명:                       LineController
 * @package                       App\Http\Controllers\Line
 * 클래스 설명:                   대사 앨범에서 대사를 불러오는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 * getLine(대사앨범ID) : 대사 앨범에서 대사 불러오기
 * registerLine(새로운 대사) : 새로운 대사를 대사 앨범에 저장
 */
namespace App\Http\Controllers\Line;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\LBook;

class LineController extends Controller
{
    //

    public function getLine($lbook_id){
    	$line = LBook::where('lbook_id',$lbook_id)->get();
    	return response()->json([
    		'line'=>$line
    	],200);
    }

    public function registerLine(Request $request){
    	$line = new LBook;
    	/*밑에 추가 바람*/
    }
}
