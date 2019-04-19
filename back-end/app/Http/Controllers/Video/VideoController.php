<?php
/**
 * 클래스명:                       VideoController
 * @package                       App\Http\Controllers\Video
 * 클래스 설명:                   영상과 관련된 정보를 다루는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 11일
 *
 * 함수 목록
 * index() : 업로드된 영상을 확인하기 위한 테스트 뷰
 * uploader() : 영상을 업로드 확인하기 위한 테스트 뷰
 * store(post값) : 영상을 스트리밍 방식으로 업로드하는 메소드
 * submit() : 뷰에 자막의 정보를 전달하는 메소드
 * videoTagList(태그번호) : 선택된 태그의 비디오 리스트 반환
 * videoAllTagList() : 모든 비디오 리스트 반환
 * video() : 실행할 영상의 정보 반환
 * getVideoRelationshipData(모델,비디오ID,boolean) : boolean이 true 이면 video_tb테이블과 일대다 관계인 테이블에있는 컬럼수와 영상정보 반환 false면 video_tb테이블과 일대다 관계인 테이블에있는 컬럼의 정보와 영상정보 반환
 * resultReturn(반환할 값,반환할 이름) : 결과값을 JSON으로 반환
 * like(비디오ID) : 추천수 반환
 * viewCNT(비디오ID) : 조회수 반환
 * report(비디오ID) : 신고수 반환
 * VWord(비디오ID) : 영상단어 반환
 * VS(비디오ID) : 영상과 관련된 100LS 리스트 반환
 */
namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Model\Video;
use App\Model\VG;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

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

    //선택된 비디오 태그
    public function videoTagList($tag){
      $video = Video::select('member_tb.nickname','video_tb.video_pk','video_tb.v_tt','tag_tb.tag')
      ->join('member_tb','video_tb.m_id','=','member_tb.member_pk')
      ->join('vtag_tb','video_tb.video_pk','=','vtag_tb.video_id')
      ->join('tag_tb','tag_tb.tag_pk','=','vtag_tb.video_id')
      ->where('vtag_tb.tag_id','=',$tag)
      ->withCount('like','viewCNT','reply')
      ->paginate(1);
      return $video;
      return $video->links();
    }

    //모든 비디오 리스트
    public function videoAllTagList(){
      $video = Video::select('member_tb.nickname','video_tb.video_pk','video_tb.v_tt','tag_tb.tag')
      ->join('member_tb','video_tb.m_id','=','member_tb.member_pk')
      ->join('vtag_tb','video_tb.video_pk','=','vtag_tb.video_id')
      ->join('tag_tb','tag_tb.tag_pk','=','vtag_tb.video_id')
      ->withCount('like','viewCNT','reply')
      ->paginate(1);
      return $video;
      return $video->links();
    }

    //비디오 실행창
    public function video($videoID){
      $result = Video::select('member_tb.nickname','video_tb.video_pk','video_tb.v_tt','video_tb.v_add','video_tb.sub_add','video_tb.trans_sub_add','d_date')
      ->join('member_tb','video_tb.m_id','=','member_tb.member_pk')
      ->where('video_pk',$videoID)
      ->with('reply','VWord')
      ->withCount('like','viewCNT')
      ->get();
      $vg = VG::where('video_pk',$videoID)->with('vocabulary')->get();
      $result[0]['vg'] = $vg;
      return $this->resultReturn($result,'video');
    }

    /*이 밑으로로는 사용 안할수도 있음*/
    public function getVideoRelationshipData($model,$videoId,$count){
      if($count){
        $result = Video::where('video_pk',$videoId)->withCount($model)->get();
        return $result;
      }else{
        $result = Video::where('video_pk',$videoId)->with($model)->get();
        return $result;
      }
    }


    public function getAllVideoRelationshipData($model,$count){
      if($count){
        $result = Video::withCount($model)->get();
        return $result;
      }else{
        $result = Video::with($model)->get();
        return $result;
      }
    }


    public function resultReturn($result,$name){
      return response()->json([
          $name=>$result,
        ]);
    }

    //추천수
    public function like($videoID){//매개변수 추후 설정
      $result = $this->getVideoRelationshipData('like',$videoID,true);
      return $this->resultReturn($result,'like');
    }

    //조회수
    public function viewCNT($videoID){//매개변수 추후 설정
      $result = $this->getVideoRelationshipData('viewCNT',$videoID,true);//수정 필요!!
      return $this->resultReturn($result,'viewCNT');
    }

    //신고수
    public function report($videoID){//매개변수 추후 설정
      $result = $this->getVideoRelationshipData('report',$videoID,true);
      return $this->resultReturn($result,'report');
    }

    //영상 단어
    public function VWord($videoID){//매개변수 추후 설정
      $result = $this->getVideoRelationshipData('VWord',$videoID,false);
      return $this->resultReturn($result,'report');
    }

    //100LS리스트
    public function VS($videoID){
      $result = $this->getVideoRelationshipData('VS',$videoID,false);
      return $this->resultReturn($result,'100LS');
    }
}
