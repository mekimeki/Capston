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
use App\Model\Member;

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
		
		public function getResult(Request $request){
			$id = $request->input("id");
			
			$id = member::where('email', $id)->select('member_pk')->get()->toArray();
			$result = sresult::select(\DB::raw('AVG(score) as score'), 'test_dt')->where('m_id', $id[0]['member_pk'])->groupBy('test_dt')->get()->toArray();

			for($i = 0; $i<count($result); $i++){
				$scores[] = $result[$i]['score'];
				$dates[] = $result[$i]['test_dt'];
			}

			return ["scores" => $scores, "dates"=>$dates];
		}
}
