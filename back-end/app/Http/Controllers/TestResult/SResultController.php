<?php
/**
 * 클래스명:                       SResultController
 * @package                       App\Http\Controllers\Result
 * 클래스 설명:                   
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 */
namespace App\Http\Controllers\TestResult;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SResult;

class SResultController extends Controller
{
    //

    public function insertResult(Request $request){
    	$result = new SResult;
    	$result->fill([
    		'm_id'=>$request->m_id,
    		'v_id'=>$request->v_id,
    		'100ls_score'=>$request->score,
    	]);
    	$result->save();
    }
}
