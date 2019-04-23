<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\Http\Controllers\Controller;

class CheckController extends Controller
{
    //
	public function Test(){
		return 'test';
	}
    public function check(Request $request){
		if(!$request->token){
			return array([
				'messages'=>'login please!!'
			]);
		}	
		$user = (array)JWT::decode($request->token,'login-key',array('HS256'));
		return $user['member_pk'];
	}
}
