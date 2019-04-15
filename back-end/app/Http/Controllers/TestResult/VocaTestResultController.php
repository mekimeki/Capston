<?php
/**
 * 클래스명:                       VocaTestResultController
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
use App\Model\VTestResult;

class VocaTestResultController extends Controller
{
    //
    public function insertResult(Request $request){
    	$result = new VTestResult;
    	$result->fill([
    		'm_id'=>$request->m_id,
    		'test_add'=>$request->test_add,
    		'test_dt'=>date("Y-m-d H:i:s"),
    		'test_score'=>$request->test_score,
    	]);
    	$result->save();
    }
}
