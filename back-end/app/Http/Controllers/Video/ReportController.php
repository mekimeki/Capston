<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Report;
use App\Http\Controllers\Member\CheckController;

class ReportController extends Controller
{
    //

    public $check;
    public function __construct(){
        $this->check = new CheckController();
    }


    public function report($video_pk,Request $request){
        $m_id = $this->check->check($request);
        if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
        }

    	$report = new Report;
    	$reportCheck = $report->where('m_id',$m_id)->where('video_pk',$video_pk)->first();
    	if(!$reportCheck){
    		/*수정필요*/
    		$report->fill([
	    		'm_id'=>$m_id,
	    		'video_pk'=>$video_pk,
    		]);
    		$report->save();
    		return response()->json([
	    		'message'=>'success'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'already reported'
	    	],200);
    	}
    }

    public function reportCancel($video_pk,Request $request){
        $m_id = $this->check->check($request);
        if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
        }

    	$report = new Report;
    	$reportCheck = $report->where('m_id',$m_id)->where('video_pk',$video_pk)->first();
    	if($reportCheck){
    		$report->where('m_id',$m_id)->where('video_pk',$video_pk)->delete();
    		return response()->json([
	    		'message'=>'success'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>' '
	    	],200);
    	}
    }
}
