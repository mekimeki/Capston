<?php
/**
 * 클래스명:                       CheckController
 * @package                       App\Http\Controllers\Member
 * 클래스 설명:                   로그인된 회원 정보 확인
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * check(Request) : Request(token(jwt토큰)) jwt토큰을 확인해서 회원인증
 */
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use \Firebase\JWT\JWT;
use App\Http\Controllers\Controller;

class CheckController extends Controller
{

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
