<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware'=>['auth']],function(){
	Route::get('/video','VideoController@index');
	Route::get('/uploader', 'VideoController@uploader')->name('uploader');
    Route::post('/upload', 'VideoController@store')->name('upload');
    Route::get('/play/{path}',function($path){
    	set_time_limit(0);//시간 초기화
        ob_clean();//버퍼 사전에 비우기
        //@ini_set('error_reporting', E_ALL & ~ E_NOTICE);//에러
        //@apache_setenv('no-gzip', 1);
        @ini_set('zlib.output_compression', 'Off');
        $dir = 'storage/'.$path;//asset('storage/'.$path);
        if(!is_file($dir))
            die('No sourch file...'.$dir);//파일 확인
        $size = filesize($dir);//파일 크기
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
            $f = fopen($dir, 'rb');//파일 열고
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
            @readfile($dir);//파일 읽기
            @ob_flush();//버퍼 출력
            flush();//비우기
        }
        exit;//이 뒤에는 출력하면 끝남
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
