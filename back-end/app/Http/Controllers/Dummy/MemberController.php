<?php

namespace App\Http\Controllers;
/**
 * 클래스명:                       FileUpload
 * @package                       App\Http\Controllers
 * 클래스 설명:                   -추가 바람-
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 11일
 *
 * 함수 목록
 * register(post값) : 입력된 값을 확인하고 회원가입
 * login(post값) : 입력된 값을 확인하고 로그인
 * logout() : 로그아웃
 * memberData() : 로그인된 회원정보 불러옴
 */

use Illuminate\Http\Request;
use App\Member;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class MemberController extends Controller
{
    //
	public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'nickname' => 'required|string|max:100|unique:member_tb',
            'email' => 'required|email|max:255|unique:member_tb',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'messages' => $validator->messages()
            ], 200);
        }

        $member = new Member;
        $member->fill($request->all());
        $member->password = bcrypt($request->password);
        $member->save();
        
        return response()->json([
            'status' => 'success',
            'data' => $member
        ], 200);
    }


	public function login(Request $request) {
		$data = $request->only('email','password');
	    $validator = Validator::make($request->all(), [
	        'email' => 'required|email|max:255',
	        'password' => 'required|string|min:8|max:255',
	    ]);
	    if($validator->fails()) {
	        return response()->json([
	            'status' => 'error',
	            'messages' => $validator->messages()
	        ], 200);
	    }
	    if(Auth::attempt($data)){
	    	$user = Member::where('email',$request->email)->first();
	    	Auth::loginUsingId($user->member_pk);
	    	session()->put('login_session',$user);
	    	return response()->json([
	    		'status'=>'login success'
	    	],200);
	    }else{
	    	return response()->json([
	    		'status'=>'login fail'
	    	],200);
	    }
	    
	}

	public function logout(){
		session()->forget('login_session');
		Auth::logout();
		return Auth::user();
	}

	public function memberData(){
		if(Auth::user()){
			return response()->json([
				'user'=>Auth::user()
			]);
		}
	}

	public function getRelationshipData($model,$count){
		if(Auth::user()){
			if($count){
				$result = Member::select('member_pk','email','nickname')->where('member_pk',Auth::user()->member_pk)->withCount($model)->get();
				return response()->json([
					$model=>$result[0][$model.'_count'],
				]);;
			}else{
				$result = Member::select('member_pk','email','nickname')->where('member_pk',Auth::user()->member_pk)->with($model)->get();
				return response()->json([
					$model=>$result[0],
				]);;
			}
		}else{
			return response()->json([
				'status'=>'login please'
			]);
		}
	}

	//100LS결과
	public function SResult(){
		return $this->getRelationshipData('SResUlt',false);
	}

	//나의비디오
	public function myVideo(){
		return $this->getRelationshipData('video',false);
	}

	//구독자수
	public function folowerCount(){
		return $this->getRelationshipData('folower',true);
	}

	//나의 단어장
	public function myWordBook(){
		return $this->getRelationshipData('wbook',false);
	}

	//어휘시험결과
	public function VTestResult(){
		return $this->getRelationshipData('VTestResult',false);
	}

	//회원어휘집
	public function MVOBook(){
		return $this->getRelationshipData('MVOBook',false);
	}

	//대사앨범
	public function LBook(){
		return $this->getRelationshipData('LBook',false);	
	}

	//페이지네이션 (테스트중)
	public function pagenation(){
		$page = Member::paginate(3);
		return $page;
	}



}
