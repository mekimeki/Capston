<?php
/**
 * 클래스명:                       UploadController
 * @package                       App\Http\Controllers\UploadController
 * 클래스 설명:                   업로드 관련 메소드 정리(작업중 추후 삭제할수도 있음)
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록

 */
namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\CheckController;
use App\Http\Controllers\Word\VideoWordController;
use App\Model\ViewCNT;
use App\Model\Video;
use App\Model\VWord;
use App\Model\Vocabulary;
use App\Model\VG;

class UploadController extends Controller
{
    //

    public function originalUpload(Request $request){
       //return $request;
       $m_id = $this->check->check($request);
       
       if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
       }
      
      $video = Video::create([
            'm_id'=> $m_id,
            'v_tt'=>$request->video->getClientOriginalName(),
            'sub_add'=>asset('storage'),//.$submit
            'v_add'=>asset('storage'),
            //'d_date'=>date('Y-m-d H:i:s',strtotime ("+7 days")),
      ]);

      $extention = $request->video->getClientOriginalExtension();
      $video_pk = $video->video_pk;
      $videoName = $video_pk.'.'.$extention;
      $video->v_add = asset('storage/'.$videoName);
      $video->v_tt = $videoName;
      //$video->where('video_pk',$video_pk)->update( ['v_add'=>$video_pk.'.'.$extention] );
      //$extention = $request->video->getClientOriginalExtension();
      $request->video->storeAs('public', $videoName);
      $video->save();
      return response()->json([
        'video_pk'=>$video_pk
      ],200);
    }

    

    public function videoEdit($video_pk){
      $video = Video::find($video_pk);
      if(!$video){
        return response()->json([
        'message'=>'none file',
        ],200);
      }
      return $video->v_add;
    }

    public function streamingUpload(Request $request){
      //return $request;
      $firstTime = $request->firstTime;
      $lastTime = $request->lastTime;
      
      $video = Video::find($request->video_pk);
      $path = $video->v_tt;
      
      $duration = $lastTime - $firstTime;
      $streaming = [
            'path'=>$path,
            'start'=>$firstTime,
            'duration'=>$duration,
        ];
      //return $request;
      $this->dispatch(new ConvertVideoForStreaming($video,$streaming));
      $this->dispatch(new ConverVideoForImage($request->video_pk,rand(1,$duration)));
      //
      Storage::disk('public')->delete($video->v_tt);
      
      return response()->json([
        'firstTime'=>$firstTime,
        'lastTime'=>$lastTime,
      ]);
    }

    public function videoEnrollment(Request $request){
      $video_pk = $request->video_pk;
      $private = $request->private;
      $v_tt = $request->v_tt;
      $explain = $request->explain;

      $tag = $request->tag;
      $category = $request->category;
      $language = $request->language;

      $video = Video::find($video_pk);
      $video->explain=$explain;
      $video->v_tt=$v_tt;

      
      if($private == 'false'){
        $video->d_date = date('Y-m-d H:i:s',strtotime ("+7 days") );
        $video->save();
      }else{
        $video->save();
      }
      $tagCheck = VTag::where('video_id',$video_pk)->where('tag_id',$tag)->get();
      $categoryCheck = VTag::where('video_id',$video_pk)->where('tag_id',$category)->get();
      $languageCheck = VTag::where('video_id',$video_pk)->where('tag_id',$language)->get();
      
      if( !isset( $tagCheck[0] ) ){
        VTag::insert(
          [
            'tag_id'=>$tag,
            'video_id'=>$video_pk,
          ]
        );
      }

      if( !isset( $categoryCheck[0] ) ){
        VTag::insert(
          [
            'tag_id'=>$category,
            'video_id'=>$video_pk,
          ]
        );
      }

      if( !isset( $languageCheck[0] ) ){
        VTag::insert(
          [
            'tag_id'=>$language,
            'video_id'=>$video_pk,
          ]
        );
      }
      
      return response()->json([
        'message'=>'success',
      ]);
    }

    public function view(Request $request){
    	$checkController = new CheckController;
    	$m_id = $checkController->check($request);
    	$video_pk = $request->video_pk;
    	if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
       	}
       	$viewCheck = ViewCNT::where('video_pk',$video_pk)->where('m_id',$m_id)->get();
       	$videoCheck = Video::where('video_pk',$video_pk)->get();
    	
       	if(isset($viewCheck[0]) ){
       		return 'already counted';
       	}else{
       		if(isset($viewCheck[0])){
       			ViewCNT::create([
       			'video_pk'=>$video_pk,
       			'm_id'=>$m_id
	       		]);
	       		return 'count up!!';
       		}
       		return 'none video';
       		
       	}
    }

    public function addWord($words,$v_id){
        for($i=0 ; $i<count($words) ; $i++){
            $vw_nm = $words[$i]['voca'];
            $w_exp = $words[$i]['explain'];
            $start_time = $words[$i]['firstTime'];
            $end_time = $words[$i]['firstTime']+2;
            VWord::create([
                'v_id'=>$v_id,
                'vw_nm'=>$vw_nm,
                'w_exp'=>$w_exp,
                'start_time'=>$start_time,
                'end_time'=>$end_time
            ]);
        }
    	
        return ;
    }

    public function loadWord($video_pk){
        $word = VWord::where('v_id',$video_pk)->orderby('start_time','asc')->get();
        $result = array();
        for($i=0 ; $i<count($word) ; $i++ ){
            $result[$i] = [
                (string)($i+1),
                [
                    $word[$i]['start_time'],
                    $word[$i]['end_time']
                ],
                $word[$i]['w_exp']
            ];
        }
        return $result;
        return response()->json([
            'word'=>$result
        ]);
    }

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
		
	}

	public function vocaSearch(Request $request){
		//return $request;
		$search = $request->voca;
		//return $search;
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
