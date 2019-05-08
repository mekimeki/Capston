<?php
/**
 * 클래스명:                       MemberVocaBookController
 * @package                       App\Http\Controllers\Voca
 * 클래스 설명:                   어휘장(수전체적인 수정및 삭제여부가 큼)
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 7일
 * 함수 목록
 */
namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MVOBook;
use App\Model\VG;
use App\Http\Controllers\Member\CheckController;

class MemberVocaBookController extends Controller
{
    //

    public function __construct(){
      $this->check = new CheckController();
    }

    public function addVocaBook(Request $request){
        $member_pk = $this->check->check($request);
       
       if(isset($member_pk[0]['messages']) ){
            return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
       }

    	$vocaBook = new MVOBook;
    	$vocaBook->fill([
    		'member_pk'=>$member_pk,
    		'title'=>$request->title,
    	]);
    	$vocaBook->save();
    		return response()->json([
	    	'message'=>'add new voca book!!'
	    ]);
    	
    }

    public function updateVocaBook(Request $request){

        $member_pk = $this->check->check($request);
        if(isset($member_pk[0]['messages']) ){
            return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }

        $mvobook_pk = $request->mvobook_pk;
        $vocaBook = MVOBook::find($mvobook_pk);
        
        if( $member_pk == $vocaBook->member_pk ){
            $vocaBook->title = $request->title;
            $vocaBook->save();
            return response()->json([
                'message'=>'updated voca book!!'
            ]);
        }else{
            return response()->json([
                'message'=>'Member information does not match!!'
            ]);
        } 
    }

    public function deleteVocaBook(Request $request){

        $member_pk = $this->check->check($request);
        if(isset($member_pk[0]['messages']) ){
            return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }
        $mvobook_pk = $request->mvobook_pk;
        $vocaBook = MVOBook::find($mvobook_pk);
        if( $member_pk == $vocaBook->member_pk ){
            MVOBook::where('mvobook_pk',$mvobook_pk)->delete();
            return response()->json([
                'message'=>'success delete voca book!!'
            ]);
        }else{
            return response()->json([
                'message'=>'Member information does not match!!'
            ]);
        }    	
    }
}
