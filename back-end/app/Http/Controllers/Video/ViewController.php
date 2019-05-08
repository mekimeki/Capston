<?php
/**
 * 클래스명:                       ViewController
 * @package                       App\Http\Controllers\Video
 * 클래스 설명:                   영상 조회수 관리
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 7일
 * 함수 목록
 * view(비디오ID,Request) : Request(jwt토큰,비디오ID) 회원1명당 1번씩 조회수를 늘림
 */
namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\CheckController;
use App\Model\ViewCNT;
use App\Model\Video;

class ViewController extends Controller
{
    //

    public function viewCount(Request $request){
    	$checkController = new CheckController;
    	$m_id = $checkController->check($request);
    	$video_pk = $request->video_pk;
    	if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
       	}
       	//$viewCheck = ViewCNT::where('video_pk',$video_pk)->where('m_id',$m_id)->get();
        $viewCheck = ViewCNT::where([
          'video_pk'=>$video_pk,
          'm_id'=>$m_id
        ])->first();
       	$videoCheck = Video::where('video_pk',$video_pk)->get();
    	  
       	if(isset($viewCheck) ){
       		return 'already counted';
       	}else{
       		if(isset($videoCheck)){
       			ViewCNT::create([
         			'video_pk'=>$video_pk,
         			'm_id'=>$m_id
	       		]);
	       		return 'count up!!';
       		}
       		return 'none video';
       		
       	}
    }
}
