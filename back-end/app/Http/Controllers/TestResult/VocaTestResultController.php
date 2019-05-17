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
use App\Model\Member;

class VocaTestResultController extends Controller
{
    //
    public function insertResult(Request $request){
			$email = $request->input('id');
			$score = $request->input('score');

			$id = member::where('email', $email)->select('member_pk')->get()->toArray();

    	vtestresult::insert([
    		'm_id'=>$id[0]["member_pk"],
    		'test_add'=>"address",
    		'test_dt'=> date('Y-m-d'),
    		'test_score'=>$score,
			]);

			return "success";
		}
		
		public function getResult(Request $request){
			$email = $request->input('id');
			
			$id = member::where("email",$email)->select('member_pk')->get()->toArray();
			$result = VTestResult::where('m_id',$id[0]['member_pk'])->select('votest_result_pk as id', 'test_dt as date', 'test_score as score')->get()->toArray();
			\Log::debug($result);

			$scores = [];
			$dates = [];

			for($i = 0; $i<count($result); $i++){
				$scores[] = $result[$i]["score"];
				$dates[] = $result[$i]["date"];
			}

			return ["scores" => $scores, "dates"=>$dates];
		}
g}
