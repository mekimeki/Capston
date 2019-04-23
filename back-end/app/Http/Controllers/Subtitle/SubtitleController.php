<?php

namespace App\Http\Controllers\Subtitle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Video;

class SubtitleController extends Controller
{
    //

    public function subtitleUpload(Request $request){
      
      $video = Video::find($request->video_pk);
      
      $subtitle = $request->video_pk.'.'.'srt';

      $video->sub_add = asset('storage/'.$subtitle);
      $request->subtitle->storeAs('public',$subtitle);
      $video->save();
      return response()->json([
        'subtitle_pk'=>$request->video_pk
      ]);

    }

    public function subtitle($video_pk){
          $arr = file(asset('storage/'.$video_pk.'.srt'));//file 꺼내기

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

          return response()->json(['subtitle'=>$arr_total_create]);
    }

    public function subtitleView($video_pk){
      $subtitle = $this->subtitle($video_pk);
      return response()->json(['subtitle'=>$subtitle]);
    }

    public function subtitleEdit($video_pk){
      $originalSumbit = $this->subtitle($video_pk);
      $subtitle = array();
      $first = 3;
      $last = 300;
      $num = 0;
      for($i=0; $i <count($originalSumbit); $i++){
        if(empty($subtitle) && $originalSumbit[$i][1][0]>$first){
            $subtitle[$num] = $originalSumbit[$i];
            $num++;
        }else if(!empty($subtitle)  && $originalSumbit[$i][1][1]<$last ){
            $subtitle[$num] = $originalSumbit[$i];
            $num++;
        }else if($originalSumbit[$i][1][1]>$last){
            return response()->json(['submit'=>$subtitle]);
        }
      }
    }

    public function generateSubmit(){
      $data = $_POST['subtitle'];
      if($_POST['subtitle']){
        $data = json_decode($data,true);
        $myfile = fopen("file.srt", "w") or die("Unable to open file!");
        $txt = "";
        for ($i=0; $i <count($data) ; $i++) {
          $msf = explode('.',$data[$i]['firstTime']);
          $data[$i]['firstTime'] = gmdate('H:i:s',$data[$i]['firstTime']).$msf[1];

          $msl = explode('.',$data[$i]['lastTime']);
          $data[$i]['lastTime'] = gmdate('H:i:s,'
          ,$data[$i]['lastTime']).$msl[1];

          $txt = $txt.$i."\n".$data[$i]['firstTime']." --> ".$data[$i]['lastTime'].$data[$i]['textArea']."\n\n";
        }
        fwrite($myfile, $txt);
        fclose($myfile);
        echo "성공";
      }else{
        echo "실패";
      }
    }
}
