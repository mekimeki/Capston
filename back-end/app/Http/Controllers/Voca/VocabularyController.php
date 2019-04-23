<?php

namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Model\Vocabulary;
use App\Model\VG;

class VocabularyController extends Controller
{
    //
	public function addVoca(Request $request,$video_pk){
		if(Auth::user()){
			$voca = new Vocabulary;
			$voca->fill($request->all());
			$voca->save();
			$vg = new VG;
			$check = $vg->where('video_pk',$video_pk)->where('gidiom_pk',$voca->vo_pk)->first();
			if($check){
				$vg->fill([
					'video_pk'=>$video_pk,
					'gidiom_pk'=>$voca->vo_pk
				]);
				return response()->json([
	    			'message'=>'voca add success!!'
	    		],200);
			}else{
				return response()->json([
	    			'message'=>'error'
	    		],200);
			}
		}else{
			return response()->json([
	    		'message'=>'login please'
	    	],200);
		}
	}
}
