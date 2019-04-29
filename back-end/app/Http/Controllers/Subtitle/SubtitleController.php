<?php

namespace App\Http\Controllers\Subtitle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video;
use Illuminate\Support\Facades\Storage;

class SubtitleController extends Controller
{
    //

   public function subtitleUpload(Request $request){
      //return $request;
      $video = Video::find($request->video_pk);
      
      $subtitle = $request->video_pk.'.'.'srt';

      $video->sub_add = asset('storage/'.$subtitle);
      $request->subtitle->storeAs('public',$subtitle);
      $video->save();
      return response()->json([
        'video_pk'=>$request->video_pk
      ]);

    }

    public function subtitle($video_pk){
      $public = Storage::disk('public')->exists($video_pk.'.srt');
      $subtitle= Storage::disk('subtitle')->exists($video_pk.'.srt');
      if( $public || $subtitle ){
        if($subtitle){
          $arr = file(asset('storage/subtitle/'.$video_pk.'.srt'));
        }else{
          $arr = file(asset('storage/'.$video_pk.'.srt'));
        }
        //file 꺼내기
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

          //return $arr_total_create[0][1][0];
        return $arr_total_create;
      }else{
        return 'none subtitle!!';
      }     
    }

    public function subtitleView($video_pk){
      $subtitle = $this->subtitle($video_pk);
      return response()->json(['subtitle'=>$subtitle]);
    }

    public function subtitleEdit(Request $request){//$firstTime,$lastTime

      $firstTime = $request->firstTime;
      $lastTime = $request->lastTime;
      $video_pk = $request->video_pk;
      
      $originalSumbit = $this->subtitle($video_pk);
      //return '!!';
      $subtitle = array();
      $num = 0;
      for($i=0; $i <count($originalSumbit); $i++){
        if(empty($subtitle) && $originalSumbit[$i][1][0]>$firstTime){
            $originalSumbit[$i][1][0]-=$firstTime;
            $originalSumbit[$i][1][1]-=$firstTime;
            $subtitle[$num] = $originalSumbit[$i];
            $num++;
        }else if(!empty($subtitle)  && $originalSumbit[$i][1][0]<$lastTime ){
            $originalSumbit[$i][1][0]-=$firstTime;
            $originalSumbit[$i][1][1]-=$firstTime;
            $subtitle[$num] = $originalSumbit[$i];
            $num++;
        }else if($originalSumbit[$i][1][0]>$lastTime){
            return response()->json([
              'subtitle'=>$subtitle
            ]);
        }
        
      }
      return response()->json(['subtitle'=>$subtitle]);
    }

    public function produceSubtitle(Request $request){//Request $request
      //return $request;
      
      $data = $request->data;//
      $data = json_decode($data,true);
      //return $request->video_pk;
      $video_pk = $request->video_pk;//
      if($data){

        $txt = "";
        for ($i=0; $i <count($data) ; $i++) {
          $msf = explode('.',$data[$i]['firstTime']);
          $data[$i]['firstTime'] = gmdate('H:i:s,',$data[$i]['firstTime']).$msf[1];
          

          $msl = explode('.',$data[$i]['lastTime']);
          $data[$i]['lastTime'] = gmdate('H:i:s,',$data[$i]['lastTime']).$msl[1];
          

          $txt = $txt.($i+1)."\n".$data[$i]['firstTime']." --> ".$data[$i]['lastTime']."\n".$data[$i]['textArea']."\n\n";

        }

        Storage::disk('subtitle')->put($video_pk.'.srt', $txt);
        Storage::disk('public')->delete($video_pk.'.srt');
        $video = Video::find($video_pk);
        $video->sub_add = asset('storage/subtitle/'.$video_pk.'.srt');
        $video->save();
        return response()->json([
          'messages'=>'subtitle edit success!!',
          'video_pk'=>$video_pk
        ]);
      }else{
        return response()->json([
          'messages'=>'subtitle edit fail!!'
        ]);
      }
    }
}
