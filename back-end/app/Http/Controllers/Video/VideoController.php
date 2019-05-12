<?php
/**
 * 클래스명:                       VideoController
 * @package                       App\Http\Controllers\Video
 * 클래스 설명:                   영상과 관련된 정보를 다루는 컨트롤러
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 11일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * index() : 업로드된 영상을 확인하기 위한 테스트 뷰
 * uploader() : 영상을 업로드 확인하기 위한 테스트 뷰
 * store(post값) : 영상을 스트리밍 방식으로 업로드하는 메소드(백앤드 테스용 )
 * originalUpload(Request) : Request(jwt토큰(token),비디오ID(video_pk)) 원본 영상을 업로드
 * streamingUpload(Request) : Request(시작시간(startTime),끝나는 시간(lastTime),비디오ID()) 전달된 정보를 바탕으로 비디오 편집
 * videoEnrollment(Request) : Request(개인용 공개용 확인 번호(private),제목(title),설명(explain),언어(language),태그(tag),장르(category),비디오ID)
 * view(비디오ID) : 실행할 비디오 정보 반환
 * myVideoPage(Request) : 사용자의 비디오 페이지네이션(테스트중)
 * videoPage(Request) : 비디오 페이지 네이션(테스트중)
 * videoEdit(비디오ID) : 편집할 비디오 주소와 스냅샷 정보를 받는 메소드
 * videoTagList(태그번호) : 선택된 태그의 비디오 리스트 반환
 * videoAllTagList() : 모든 비디오 리스트 반환
 * getVideoRelationshipData(모델,비디오ID,boolean) : boolean이 true 이면 video_tb테이블과 일대다 관계인 테이블에있는 컬럼수와 영상정보 반환 false면 video_tb테이블과 일대다 관계인 테이블에있는 컬럼의 정보와 영상정보 반환
 * resultReturn(반환할 값,반환할 이름) : 결과값을 JSON으로 반환
 * like(비디오ID) : 추천수 반환
 * viewCNT(비디오ID) : 조회수 반환
 * report(비디오ID) : 신고수 반환
 * VWord(비디오ID) : 영상단어 반환
 * VS(비디오ID) : 영상과 관련된 100LS 리스트 반환
 * streaming(비디오ID) : 비디오 스트리밍 실행 메소드(테스트중)
 */
namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Model\Video;
use App\Model\Member;
use App\Model\VG;
use App\Model\VTag;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\ConverVideoForImage;
use App\Jobs\ConverVideoForThumbnail;
use App\Http\Controllers\Word\VideoWordController;
use App\Http\Controllers\Voca\VocabularyController;
use App\Http\Controllers\Subtitle\SubtitleController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\CheckController;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    //

    public $check;

    public function __construct(){
      $this->check = new CheckController();
    }

    public function index(){
        //$videos = Video::orderBy('created_at', 'DESC')->get();
        return view('videos');//->with('videos',$videos);
    }

    public function uploader(){
        return view('uploader');
    }

    public function store(Request $request){
        //Storage::disk('public')->delete('43.mp4');
        //return $this->dispatch(new ConverVideoForImage(173));
        $path = str_random(16) . '.' . $request->video->getClientOriginalExtension();
        //Storage::disk('video')->put( $path,$request->video);
        //$submit = $request->submit->getClientOriginalName().'.'. $request->submit->getClientOriginalExtension();
        $request->video->storeAs('public', $path);
        $video = new Video;
        $video->fill([
            'm_id'=> 2,//$m_id
            'v_tt'=>$request->video->getClientOriginalName(),
            'sub_add'=>asset('storage/word0.srt'),//.$submit
            'v_add'=>asset('storage'),
            //'d_date'=>date('Y-m-d H:i:s',strtotime ("+7 days")),
        ]);
        $video->save();
        //return $video->video_pk;
        //$request->submit->storeAs('public', $video->video_pk.'.srt');
        $video->where('video_pk',$video->video_pk)->update( ['sub_add'=>asset('storage/'.$video->video_pk.'.srt')] );

        //$request->submit->storeAs('public', $video->video_pk.'.'.$request->submit->getClientOriginalExtension());
        $streaming = [
            'path'=>$path,
            'start'=>5,
            'duration'=>3,
        ];
        $this->dispatch( new ConvertVideoForStreaming($video,$streaming) );//
        
        return redirect('/video');
        return response()->json([
            'id' => $video->id,
        ], 201);
        
    }

    public function originalUpload(Request $request){
       //return $request;
       $m_id = $this->check->check($request);
       
       if(isset($m_id[0]['messages']) ){
            return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
       }
      
      $video = Video::create([
            'm_id'=> $m_id,
            'v_tt'=>$request->video->getClientOriginalName(),
            'sub_add'=>asset('storage'),//.$submit
            'v_add'=>asset('storage'),
            //'d_date'=>date('Y-m-d H:i:s',strtotime ("+7 days")),
      ]);

      $extention = $request->video->getClientOriginalExtension();
      $video_pk = $video->video_pk;
      $videoName = $video_pk.'.'.$extention;
      $video->v_add = asset('storage/'.$videoName);
      $video->v_tt = $videoName;
      //$video->where('video_pk',$video_pk)->update( ['v_add'=>$video_pk.'.'.$extention] );
      //$extention = $request->video->getClientOriginalExtension();
      $request->video->storeAs('public', $videoName);
      $video->save();

      $this->dispatch(new ConverVideoForImage($video_pk,$videoName));//,$duration
      return response()->json([
        'video_pk'=>$video_pk
      ],200);
    }

    public function videoEdit($video_pk){
      $video = Video::find($video_pk);
      if(!$video){
        return response()->json([
        'message'=>'none file',
        ],200);
      }
      return response()->json([
        'video'=>$video->v_add,
      ]);
      return $video->v_add;
    }

    public function snapShot($video_pk){
      $img = array();
      for($i=0 ; $i<10 ; $i++){
        $num = $i+1;
        $img[$i] = asset('storage/img/'.$video_pk.'_'.$num.'.jpg');
      }
      return response()->json([
        'img'=>$img,
      ]);
    }

    public function streamingUpload(Request $request){
      
      $firstTime = $request->firstTime;
      $lastTime = $request->lastTime;
      
      $video = Video::find($request->video_pk);
      
      $path = $video->v_tt;
      
      $duration = $lastTime - $firstTime;
      $streaming = [
            'path'=>$path,
            'start'=>$firstTime,
            'duration'=>$duration,
        ];
      //return $request;
      $this->dispatch(new ConvertVideoForStreaming($video,$streaming));
      $this->dispatch(new ConverVideoForThumbnail($request->video_pk));//rand(1,$duration)
      //
      Storage::disk('public')->delete($video->v_tt);
      
      return response()->json([
        'firstTime'=>$firstTime,
        'lastTime'=>$lastTime,
      ]);
    }

    public function videoEnrollment(Request $request){
      //return $request;
      $video_pk = $request->video_pk;
      $private = $request->private;
      $title = $request->title;
      $explain = $request->explain;
      if(!isset($explain)){
        $explain = '';
      }
      $language = $request->language;
      $tag = $request->tag;
      $category = $request->category;
      

      $video = Video::find($video_pk);
      $video->explain=$explain;
      $video->v_tt=$title;

      \Log::debug('in roll');

      if($private == 1){
        $video->d_date = date('Y-m-d H:i:s',strtotime ("+7 days") );
        $video->save();
      }else{
        $video->save();
      }
      /*
      $tagCheck = VTag::where('video_id',$video_pk)->where('tag_id',$tag)->get();
      $categoryCheck = VTag::where('video_id',$video_pk)->where('tag_id',$category)->get();
      $languageCheck = VTag::where('video_id',$video_pk)->where('tag_id',$language)->get();
      
      if( !isset( $tagCheck[0] ) ){
        VTag::insert(
          [
            'tag_id'=>$tag,
            'video_id'=>$video_pk,
          ]
        );
      }

      if( !isset( $categoryCheck[0] ) ){
        VTag::insert(
          [
            'tag_id'=>$category,
            'video_id'=>$video_pk,
          ]
        );
      }

      if( !isset( $languageCheck[0] ) ){
        VTag::insert(
          [
            'tag_id'=>$language,
            'video_id'=>$video_pk,
          ]
        );
      }
      */


      Storage::disk('img')->delete([
            $video_pk.'_1'.'.jpg',
            $video_pk.'_2'.'.jpg',
            $video_pk.'_3'.'.jpg',
            $video_pk.'_4'.'.jpg',
            $video_pk.'_5'.'.jpg',
            $video_pk.'_6'.'.jpg',
            $video_pk.'_7'.'.jpg',
            $video_pk.'_8'.'.jpg',
            $video_pk.'_9'.'.jpg',
            $video_pk.'_10'.'.jpg',
        ]);
      return response()->json([
        'message'=>'success',
      ]);
    }

    public function videoTag(){
       $vTag = new VTag;
       $language = $vTag->where('video_id',130)->where('tag_id','>=',1)->where('tag_id','<=',3)->with('tag')->get();
       $tag = $vTag->where('video_id',130)->where('tag_id','>=',4)->where('tag_id','<=',5)->with('tag')->get();
       $category = $vTag->where('video_id',130)->where('tag_id','>=',6)->with('tag')->get();
       return response()->json([
          'language'=>$language,
          'tag'=>$tag,
          'category'=>$category,
       ]);
    }

    public function videoImageUpload(Request $request){
      $this->dispatch(new ConverVideoForImage($request->video_pk,$request->frameTime));
    }

    //선택된 비디오 태그
    public function videoTagList($tag){
      $video = Video::select('member_tb.nickname','video_tb.video_pk','video_tb.v_tt','tag_tb.tag')
      ->join('member_tb','video_tb.m_id','=','member_tb.member_pk')
      ->join('vtag_tb','video_tb.video_pk','=','vtag_tb.video_id')
      ->join('tag_tb','tag_tb.tag_pk','=','vtag_tb.video_id')
      ->where('vtag_tb.tag_id','=',$tag)

      ->withCount('like','viewCNT','reply');
      //->paginate(1);
      return $video->count();
      //return $video;
      return $video->links();
    }

    //모든 비디오 리스트
    public function videoAllTagList(){
      $video = Video::select('member_tb.nickname','video_tb.video_pk','video_tb.v_tt','tag_tb.tag')
      ->join('member_tb','video_tb.m_id','=','member_tb.member_pk')
      ->join('vtag_tb','video_tb.video_pk','=','vtag_tb.video_id')
      ->join('tag_tb','tag_tb.tag_pk','=','vtag_tb.video_id')
      ->withCount('like','viewCNT','reply')
      //->whereNotNull('explain')
      ->paginate(1);
      //return $video;
      $test = $video->links();

      return $video;
    }

    //비디오 실행창
    public function view($video_pk){//10초 영상 재수정.mp4
      $video = Video::where('video_pk',$video_pk)->with('member')->withCount('like')->with('reply')->withCount('ViewCNT')->get();
      
      if(isset($video[0])){
        $voca = new VocabularyController;
        $voca = $voca->loadVoca($video_pk);
        $word = new VideoWordController;
        $word = $word->loadWord($video_pk);
        $subtitle = new SubtitleController;
        $subtitle = $subtitle->subtitleView($video_pk);
        $video[0]['v_add'] = asset('storage/video/'.$video_pk.'.mp4');
        //$url = asset('api/video/steaming/'.$video_pk);
        return response()->json([
          'video'=>$video[0],
          'subtitle'=>$subtitle,
          'voca'=>$voca,
          'word'=>$word,
        ]);
      }else{
        return response()->json([
          'error'=>'none video'
        ]);
      }
      
      //return $this->resultReturn(,'video');
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

    public function videoPage(Request $request){//Request $request
      $video = Video::select('member_tb.nickname','video_tb.video_pk','video_tb.v_tt','tag_tb.tag')
      ->join('member_tb','video_tb.m_id','=','member_tb.member_pk')
      ->join('vtag_tb','video_tb.video_pk','=','vtag_tb.video_id')
      ->join('tag_tb','tag_tb.tag_pk','=','vtag_tb.tag_id')
      ->withCount('like','viewCNT','reply');
      //->get();
      $page = $request->page;//$request->page;
    
      define('ONE_PAGE_LIST',5);
      define('PAGE_LINK',5);
      $countSum = $video->count();
      if($countSum>=0){
        $pageCount = ceil($countSum/ONE_PAGE_LIST);
        if($page > $pageCount){
           $page = $pageCount;
        }
        if($page<1){
          $page=1;
        }

        $start = ($page-1)*ONE_PAGE_LIST;
        $onePageList = $video->skip($start)->take(ONE_PAGE_LIST)->get();

        $firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
        $lastLink = $firstLink+PAGE_LINK-1;
        if($lastLink>$pageCount){
            $lastLink = $pageCount;
        }
      }
      return response()->json([
        'onePageList'=>$onePageList,
        'firstLink'=>$firstLink,
        'lastLink'=>$lastLink,
        'page'=>$page,
      ]);
    }


      //나의비디오
  public function myVideoPage(Request $request){
    $page = $request->page;
    if($page == 0){
      $m_id = $this->check->check($request);
      if(isset($m_id[0]['messages']) ){
        return response()->json([ 'messages'=>$m_id[0]['messages'] ],200);
      }
    }else{
      $m_id = $request->m_id;
    }
    
    define('ONE_PAGE_LIST',10);
    define('PAGE_LIST',10);
    $video = Video::where('m_id',$m_id)->with('member:email,member_pk');
    ;//$request->page;
    $videoCount = $video->count();
    //return $videoCount;
    if($videoCount>=0){
      $pageCount = ceil($videoCount/ONE_PAGE_LIST);
      if($page>$pageCount){
        $page = $pageCount;
      }
      if($page<1){
        $page=1;
      }
      $start = ($page-1)*ONE_PAGE_LIST;
      $onePageList = $video->skip($start)->take(ONE_PAGE_LIST)->get();
      $firstLink = floor(($page-1)/PAGE_LIST)*ONE_PAGE_LIST+1;
      $lastLink = $firstLink+PAGE_LIST-1;
      if($lastLink>$pageCount){
              $lastLink = $pageCount;
          }
    }

    return response()->json([
      'onePageList'=>$onePageList,
      'firstLink'=>$firstLink,
      'lastLink'=>$lastLink,
      'page'=>$page,
      'user'=>$onePageList[0]['member'],
    ]);

  }

  public function streaming($video_pk){
    /*
    //return Storage::disk('subtitle')->get('182.srt');
    //$dir = Storage::disk('video')->exists($video_pk.'.mp4');
    set_time_limit(0);//시간 초기화
    ob_clean();//버퍼 사전에 비우기
    //@ini_set('error_reporting', E_ALL & ~ E_NOTICE);//에러
    @apache_setenv('no-gzip', 1);
    @ini_set('zlib.output_compression', 'Off');
    if(! Storage::disk('video')->exists($video_pk.'.mp4') )
      die('No sourch file...'.$video_pk.'.mp4');//파일 확인
    $size = Storage::disk('video')->size($video_pk.'.mp4');//파일 크기
    
    header('Content-type: application/octet-stream');//스트림 형식으로 
    if(isset($_SERVER['HTTP_RANGE'])){//이전에 전송테그가 존재할시(특정구간부터 시작시)
      $ranges = array_map('intval',explode('-',substr($_SERVER['HTTP_RANGE'], 6)));
      if(!$ranges[1])//파일 크기가 존재하지 않는다면
        $ranges[1] = $size - 1;//넣고
      header('HTTP/1.1 206 Partial Content');
      header('Accept-Ranges: bytes');//바이트 전송
      header('Content-Length: ' . $size);//파일크기
      header(
        sprintf(
          'Content-Range: bytes %d-%d/%d',
          $ranges[0], // The start range
          $ranges[1], // The end range
          $size // Total size of the file
        )
      );
      $f = Storage::disk('video')->get($video_pk.'.mp4');//파일 열고

      $chunkSize = 8192;//파일 1번 읽을때 크기
      fseek($f, $ranges[0]);//데이터 요청위치까지 이동
      while(true){//읽는반복문
        if(ftell($f) >= $ranges[1])break;//파일 위치가 길이를 초과할 경우 종료
        echo fread($f, $chunkSize);//파일 읽고 출력
        @ob_flush();//버퍼 출력
        flush();//비운다
      }
    }else {
      header('Content-Length: ' . $size);//파일 크기
      @readfile('http://172.26.4.110/storage/video/182.mp4');//파일 읽기
      @ob_flush();//버퍼 출력
      flush();//비우기
    }
    exit;//이 뒤에는 출력하면 끝남
    */
    set_time_limit(0);//최대 실행시간 제한 스크립트를 실행할 수있는 시간 (초)을 설정하십시오. 이 값에 도달하면 스크립트에서 치명적인 오류를 반환합니다. /최대 실행 시간 (초). 0으로 설정하면 시간 제한이 적용되지 않습니다.

    // Clears the cache and prevent unwanted output
    ob_clean();// 출력없이 버퍼만 비우고, 종료하지는 않습니다
    @ini_set('error_reporting', E_ALL & ~ E_NOTICE);
    /*
    ini_set ( string $varname , string $newvalue )

    $varname
    설정 변수의 이름

    $newvalue
    설정을 변경할 새로운 값
    */
    @apache_setenv('no-gzip', 1);
    @ini_set('zlib.output_compression', 'Off');

    // Stream videos to HTML5 video container using HTTP & PHP
    // http://licson.net/post/stream-videos-php/
     // The media file's location
    //return $file;
    $video = Video::find($video_pk);
    $video = $video->v_tt;
    
    if( Storage::disk('video')->exists($video_pk.'.mp4') ){
      $file = './storage/video/'.$video_pk.'.mp4';
      $size = Storage::disk('video')->size($video_pk.'.mp4');
    }else if( Storage::disk('public')->exists($video) ){
      $file = './storage/'.$video;
      $size = Storage::disk('public')->size($video);
    }else{
      die('동영상정보가 존재하지 않습니다.');// 메시지를 출력하고 현재 스크립트를 종료합니다.
    }
    
    $mime = "application/octet-stream"; // The MIME type of the file, this should be replaced with your own.
     // The size of the file

    // Send the content type header
    header('Content-type: ' . $mime);

    // Check if it's a HTTP range request
    if(isset($_SERVER['HTTP_RANGE'])){

        // Parse the range header to get the byte offset
        $ranges = array_map(
            'intval', // Parse the parts into integer
            explode(
                '-', // The range separator
                substr($_SERVER['HTTP_RANGE'], 6) // Skip the `bytes=` part of the header
            )
        );

        // If the last range param is empty, it means the EOF (End of File)
        if(!$ranges[1]){
            $ranges[1] = $size - 1;
        }

        // Send the appropriate headers
        header('HTTP/1.1 206 Partial Content');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . $size);

        // Send the ranges we offered
        header(
            sprintf(
                'Content-Range: bytes %d-%d/%d', // The header format
                $ranges[0], // The start range
                $ranges[1], // The end range
                $size // Total size of the file
            )
        );

        // It's time to output the file
        $f = fopen($file,'rb'); // Open the file in binary mode
        //$f = file('http://172.26.4.110/storage/video/182.mp4', FILE_BINARY); 
        //return $f;

        //$f = Storage::disk('video')->get($video_pk.'.mp4','rb');

        $chunkSize = 8192; // The size of each chunk to output

        // Seek to the requested start range
        fseek($f, $ranges[0]);

        // Start outputting the data
        while(true){
            // Check if we have outputted all the data requested
            if(ftell($f) >= $ranges[1]){
                break;
            }

            // Output the data
            echo fread($f, $chunkSize);

            // Flush the buffer immediately
            @ob_flush();
            flush();
        }
    }
    else {

        // It's not a range request, output the file anyway
        header('Content-Length: ' . $size);

        // Read the file
        @readfile($file);

        // and flush the buffer
        @ob_flush();
        flush();
    }
  }


}
