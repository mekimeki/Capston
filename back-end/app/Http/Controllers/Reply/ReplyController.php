<?php
/**
 * 클래스명:                       ViewController
 * @package                       App\Http\Controllers\Reply
 * 클래스 설명:                   댓글
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * commentAdd(Request) : 댓글 추가
 * commentDelete(Request) : 삭제
 */
namespace App\Http\Controllers\Reply;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Reply;

class ReplyController extends Controller
{
    //
    public function commentAdd(Request $request){
    	$parent = $request->parent;
    	if(isset($parent)){
    		Reply::create([
    			'video_id'=>$request->video_id,
    			'replier_id'=>$request->replier_id,
    			'reply'=>$request->reply,
    			'date'=>date('Y-m-s H:i:s'),
    			'parent'=>$parent
    		]);
    	}else{
    		Reply::create([
    			'video_id'=>$request->video_id,
    			'replier_id'=>$request->replier_id,
    			'reply'=>$request->reply,
    			'date'=>date('Y-m-s H:i:s'),
    		]);
    	}
    }

    public function commentDelete(Request $request){
    	$reply_pk = $request->reply_pk;
    	$parent = $request->parent;
    	$reply = Reply::find($reply_pk);
 
    	if(isset($parent)){
    		Reply::where($parent,$reply_pk)->delete();
    	}
    	
    	$reply->delete();
    }

    public function getComment($video_pk){

    }
}
