<?php


/**
 * 클래스명:                       MemberController
 * @package                       App\Http\Controllers\Member
 * 클래스 설명:                   회원 정보를 다루는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 11일
 *
 * 함수 목록
 * register(post값) : 입력된 값을 확인하고 회원가입
 * login(post값) : 입력된 값을 확인하고 로그인
 * logout() : 로그아웃
 * memberData() : 로그인된 회원정보 불러옴
 * getRelationshipData(모델,boolean) boolean이 true 이면 member_tb테이블과 일대다가 관계인 테이블에있는 컬럼수와 회원정보 반환 false면 member_tb테이블과 일대가 관계인 테이블에있는 컬럼의 정보와 회원정보 반환
 * SResult() : 로그인된 회원의 100LS결과 반환
 * myVideo() : 로그인된 회원의 비디오 리스트 반환
 * folowerCount() : 로그인된 회원의 구독자수 반환
 * myWordBook() : 로그인된 회원의 단어장 반환
 * VTestResult() : 로그인된 회원의 어휘 시험결과 반환
 * MVOBook() : 로그인된 회원의 어휘집 반환
 * LBook() : 로그인된 회원의 대사앨범 결과 반환
 * SResult() : 로그인된 회원의 100LS결과 반환
 */
namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Model\Member;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Http\Controllers\Member\CheckController;
use \Firebase\JWT\JWT;

class MemberController extends Controller
{
    //
	public $check;
    public function __construct(){
    	$this->check = new CheckController();
    }

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
        $member->fill($request->only('email','password','nickname'));
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
	    	$jwt = JWT::encode(Auth::user(), 'login-key','HS256');
	    	return response()->json([
	    		'status'=>'login success',
	    		'token'=>$jwt,
	    	],200);
	    }else{
	    	return response()->json([
	    		'status'=>'login fail'
	    	],200);
	    }
	}

	public function check(Request $request){
		if(!$request->token){
			return json([
				'messages'=>'you are not have token'
			],400);
		}	
		$user = (array)JWT::decode($request->token,'login-key',array('HS256'));
		return $user;
		return $user['member_pk'];
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

	public function getRelationshipData($member_pk,$model,$count){
		
		if($count){
				$result = Member::select('member_pk','email','nickname')->where('member_pk',$member_pk)->withCount($model)->get();
				return response()->json([
					$model=>$result[0][$model.'_count'],
				]);;
			}else{
				$result = Member::select('member_pk','email','nickname')->where('member_pk',$member_pk)->with($model)->get();
				//return $result[0];
				return response()->json([
					$model=>$result[0],
				]);;
		}
		/*
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
		*/
	}

	//100LS결과
	public function SResult(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'SResUlt',false);
	}

	//나의비디오
	public function myVideo(Request $request){
		$member_pk = $this->check->check($request);

		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'video',false);
	}

	//구독자수
	public function folowerCount(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'folower',true);
	}

	//나의 단어장
	public function myWordBook(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'wbook',false);
	}

	//어휘시험결과
	public function VTestResult(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'VTestResult',false);
	}

	//회원어휘집
	public function MVOBook(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'MVOBook',false);
	}

	//대사앨범
	public function LBook(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		return $this->getRelationshipData($member_pk,'LBook',false);	
	}

	//페이지네이션 (테스트중)
	public function pagenation(Request $request){
		$member_pk = $this->check->check($request);
		if(isset($member_pk[0]['messages']) ){
			return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
		}
		$page = Member::paginate(3);
		return $page;
	}

	public function token(){
		$token = encrypt(1);
		//$token = decrypt($token);
		return $token;
	}

	public function test(){
		return $this->check->Test();
	}

}
