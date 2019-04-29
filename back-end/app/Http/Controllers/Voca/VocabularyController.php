<?php

namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Vocabulary;
use App\Model\VG;

class VocabularyController extends Controller
{
    

	public function addVoca(Request $request){
		$vocas = json_decode( $request->vocas );
		if(count($voca)>0){
			for($i=0 ; $i<count($voca) ; $i++){
				if(!$vocas[$i]['indata']){
					$data = Vocabulary::create([
								'voca'=>$voca[$i]['voca'],
								'explain'=>$voca[$i]['explain'],
							]);
					VG::create([
						'video_pk'=>$request->video_pk,
						'gidiom_pk'=>$data->vo_pk,
						'start_time'=>$voca[$i]['start_time'],
						'end_time'=>$voca[$i]['end_time'],
					]);
				}else{
					VG::create([
						'video_pk'=>$request->video_pk,
						'gidiom_pk'=>$voca[$i]['vo_pk'],
						'start_time'=>$voca[$i]['start_time'],
						'end_time'=>$voca[$i]['end_time'],
					]);
				}				
			}
		}
	}

	public function vocaSearch(Request $request){
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

	public function loadVoca(){
        $voca = VG::where('video_pk',1)->with('vocabulary')->get();
        //return $voca;
        $result = array();
        for($i=0 ; $i<count($voca) ; $i++ ){
        	$vocabulary = $voca[$i]['vocabulary'];
            $result[$i] = [
                (string)($i+1),
                [
                    $voca[$i]['start_dt'],
                    //$voca[$i]['end_time']
                ],
                $vocabulary['voca'].' '.$vocabulary['explain']
            ];
        }
        return response()->json([
            'voca'=>$result
        ]);
    }
}
