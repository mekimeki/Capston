<?php

namespace App\Http\Controllers;
/**
 * 클래스명:                       FileUpload
 * @package                       App\Http\Controllers
 * 클래스 설명:                   -추가 바람-
 * 만든이:                        3-WDJ 3조 ナナイロトリ 1501107 최찬민
 * 만든날:                        2019년 4월 11일
 *
 * 함수 목록
 * -추가 바람-
 *
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
				$result = Member::where('member_pk',Auth::user()->member_pk)->withCount($model)->get();
				return response()->json([
					$model=>$result[0][$model.'_count'],
				]);;
			}else{
				$result = Member::where('member_pk',Auth::user()->member_pk)->with($model)->get();
				return response()->json([
					$model=>$result[0][$model],
				]);;
			}
		}else{
			return response()->json([
				'status'=>'login please'
			]);
		}
	}

	public function SResult(){
		return $this->getRelationshipData('SResUlt',false);
	}

	public function myVideo(){
		return $this->getRelationshipData('video',false);
	}

	public function folowerCount(){
		return $this->getRelationshipData('folower',true);
	}

	public function myWordBook(){
		return $this->getRelationshipData('wbook',false);
	}

	public function VTestResult(){
		return $this->getRelationshipData('vtestresult',false);
	}


	public function pagenation(){
		$page = Member::paginate(3);
		return $page;
	}

}
