<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Model\Member;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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

    public function login(Request $request){
    	//return Auth::guard('api')->factory();
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
	    //$user = Member::where('email',$request->email)->first();
	    //Auth::loginUsingId($user->member_pk);
	    
	    if ( Auth::attempt($data) ) {
	        session()->put('login_token',str_random(10));
	        return session()->get('login_token');
	    }else{
	    	return response()->json([
	            'status' => 'error',
	            'messages' => 'email or password not match'
	        ], 200);
	    }
		
	    return $this->respondWithToken($token);
    }
}
