<?php

namespace App\Http\Controllers\Voca;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MVOBook;
use App\Model\VG;

class MemberVocaBookController extends Controller
{
    //

    public function addVocaBook(Request $request){
    	if(Auth::user()){
    		$vocaBook = new MVOBook;
    		$vocaBook->fill([
    			'member_pk'=>Auth::user()->member_pk,
    			'title'=>$request->title,
    		]);
    		$vocaBook->save();
    		return response()->json([
	    		'message'=>'add new voca book!!'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'login please!!'
	    	],200);
    	}
    }

    public function updateVocaBook(Request $request,$mvobook_pk){
    	if(Auth::user()){
    		$vocaBook = new MVOBook;
    		$vocaBook->where('mvobook_pk',$mvobook_pk)->update(['title'=>$request->title]);
    		return response()->json([
	    		'message'=>'update voca book!!'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'login please!!'
	    	],200);
    	}
    }

    public function deleteVocaBook($mvobook_pk){
    	if(Auth::user()){
    		$vocaBook = new MVOBook;
    		$vocaBook->where('mvobook_pk',$mvobook_pk)->delete();
    		return response()->json([
	    		'message'=>'success delete voca book!!'
	    	],200);
    	}else{
    		return response()->json([
	    		'message'=>'login please!!'
	    	],200);
    	}
    }
}
