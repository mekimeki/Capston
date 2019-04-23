<?php
/**
 * 클래스명:                       AttendanceController
 * @package                       App\Http\Controllers\Member
 * 클래스 설명:                   출석체크 하는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 14일
 *
 * 함수 목록
 * attendance() : 출석하기
 */
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Attendance;

use App\Http\Controllers\Member\CheckController;

class AttendanceController extends Controller
{
    //

    public $check;

    public function __construct(){
      $this->check = new CheckController();
    }

	public function attendance(Request $request){
		$member_pk = $this->check->check($request);
        if(isset($member_pk[0]['messages']) ){
            return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }

		$date = date("Y-m-d 00:00:00");
 		$attendance = new Attendance;
 		$attendanceCheck = $attendance->where('member_pk',$member_pk)->where('attd_dt',$date)->first();
 		if(!$attendanceCheck){
 			$attendance->fill([
 			'member_pk'=>$member_pk,
 			'attd_dt'=>$date,
	 		]);
	 		$attendance->save();
	 		return response()->json([
		    	'message'=>'attendance check!'
		    ],200);
	 	}else{
	 		return response()->json([
		    	'message'=>'Today already checked!!'
		    ],200);
	 	}

	}
}
