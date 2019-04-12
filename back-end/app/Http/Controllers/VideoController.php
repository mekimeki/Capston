<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    //
    public function index(){
        //$videos = Video::orderBy('created_at', 'DESC')->get();
        return view('videos');//->with('videos',$videos);
    }

    public function uploader(){
        return view('uploader');
    }

    public function store(Request $request){
        $path = str_random(16) . '.' . $request->video->getClientOriginalExtension();
        //$submit = $request->submit->getClientOriginalName().'.'. $request->submit->getClientOriginalExtension();
        $request->video->storeAs('public', $path);
        //$this->videoCut($path,$first,$last);
        /*
        $video = Video::create([
            'm_id'=> Auth::user()->member_pk,
            'v_add'=> 'public',
            'v_tt'=>$request->video->getClientOriginalName(),
            'sub_add'=>$request->submit->getClientOriginalName(),
        ]);
        */
        //$request->submit->storeAs('public', $video->video_pk.'.'.$request->submit->getClientOriginalExtension());
        $this->dispatch(new ConvertVideoForStreaming($path));//$video

        return redirect('/video');
        return response()->json([
            'id' => $video->id,
        ], 201);
        
    }

    public function submit(){
          $arr = file(asset('storage/word0.srt'));//file 꺼내기

          $arr_total = array();//array
          $num = 0;//
          $check = (int)$arr[0]+1;//first number check
          $arr_total[$num] = "";//total array;
          ///1 for
          for ($i=0; $i <count($arr) ; $i++) {
            $arr[$i] = trim($arr[$i]);//
            if($arr[$i] == $check){
              $num++;
              $arr_total[$num] = "";
              $check++;
            }
            if($arr[$i] != ""){
                $arr_total[$num] = $arr_total[$num]."#".$arr[$i];
            }
          }
          //2 for
          $arr_total_json = array();
          for ($i=0; $i <count($arr_total); $i++) {
            $arr_total[$i] = substr($arr_total[$i],1);
            $arr_total_create[$i] = explode("#",$arr_total[$i]);
          }
          //return $arr_total_create;
          //video current Time 은 초 단위이다.
          for ($i=0; $i <count($arr_total_create); $i++) {
            $arr_total_create[$i][1] = explode("--> ",$arr_total_create[$i][1]);
            for ($s=0; $s <2; $s++) {
              $time = explode(":",$arr_total_create[$i][1][$s]);
              $time[0] = (int)$time[0]*60*60;//시
              $time[1] = (int)$time[1]*60;//분
              $time[2] = explode(",",$time[2]);//초
              $time[2][0] = (int)$time[2][0];//밀리세컨드
              $arr_total_create[$i][1][$s] = $time[0] + $time[1] + $time[2][0] + (int)$time[2][1]/1000;
            }
          }

          //3 for
          $total_word = array();
          $total = array();
          for ($i=0; $i <count($arr_total_create); $i++) {
            $total_word[$i] = "";
            for ($s=2; $s < count($arr_total_create[$i]); $s++) {
              $total_word[$i] = $total_word[$i]."\n".$arr_total_create[$i][$s];
            }
            array_splice($arr_total_create[$i], 2, count($arr_total_create[$i]));
            $arr_total_create[$i][2] = $total_word[$i];
          }

          return response()->json(['submit'=>$arr_total_create]);
    }
}
