<?php
/**
 * 클래스명:                       VocabularyController
 * @package                       App\Http\Controllers\Voca
 * 클래스 설명:                   영상 업로드시 문법 및 단어 추가
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * addVoca(Request) : Request(비디오ID(video_pk),문법(content),단어(word)) 문법 및 단어 추가
 * vocaSearch(Request) : Request(문법(voca)) 문법검색
 * loadVoca(비디오ID) : 비디오ID로 해당 비디오와 관련된 문법정보 반환
 */
namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Word\VideoWordController;
use Illuminate\Support\Facades\Auth;
use App\Model\Vocabulary;
use App\Model\VG;

class VocabularyController extends Controller
{
    
	public function addVoca(Request $request){
		//$request;
		$wordController = new VideoWordController;
		$video_pk = $request->video_pk;
		$content = json_decode( $request->content ,true);
		$word = json_decode( $request->word , true );
		$wordController->addWord($word,$video_pk);

		if(count($content)>0){
			for($i=0 ; $i<count($content) ; $i++){
				if($content[$i]['vo_pk'] == false){
					$data = new Vocabulary;
					$data ->fill([
								'voca'=>$content[$i]['voca'],
								'explain'=>$content[$i]['explain'],
							]);
					$data->save();
					//return $data;
					VG::create([
						'video_pk'=>$video_pk,
						'gidiom_pk'=>$data->vo_pk,
						'start_time'=>$content[$i]['firstTime'],
						'end_time'=>$content[$i]['firstTime']+2,
					]);
				}else{
					VG::create([
						'video_pk'=>$video_pk,
						'gidiom_pk'=>$content[$i]['vo_pk'],
						'start_time'=>$content[$i]['firstTime'],
						'end_time'=>$content[$i]['firstTime']+2,
					]);
				}				
			}
		}

		return 'success';
		
	}

	public function vocaSearch(Request $request){
		//return $request;
		$search = $request->voca;
		
		$result = Vocabulary::where('voca','like','%'.$search.'%')->get();
		if(count($result) == 0){
			return response()->json([
				'indata'=>false
			]);
		}else{
			return response()->json([
				'data'=>$result,
				'indata'=>true
			]);
		}
	}

	public function loadVoca($video_pk){
        $voca = VG::where('video_pk',$video_pk)->with('vocabulary')->orderby('start_time','asc')->get();
        //return $voca;
        $result = array();
        //return $voca[0]['start_time'];
        for($i=0 ; $i<count($voca) ; $i++ ){
        	$vocabulary = $voca[$i]['vocabulary'];
            $result[$i] = [
                (string)($i+1),
                [
                    $voca[$i]['start_time'],
                    $voca[$i]['end_time']
                ],
                $vocabulary['voca'].' '.$vocabulary['explain']
            ];
        }
        return $result;
        return response()->json([
            'voca'=>$result
        ]);
    }
}
