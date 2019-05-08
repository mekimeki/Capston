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

//<<<<<<< Updated upstream
//비디오테스트
Route::group(['middleware'=>['auth']],function(){
	
});
Route::get('/video','Video\VideoController@index');
Route::get('/uploader', 'Video\VideoController@uploader')->name('uploader');
Route::post('/upload', 'Video\VideoController@store')->name('upload');
Route::get('submit','Video\VideoController@submit');
Route::get('/ffmpeg',function(){
	return view('ffmpeg');
});

//선택된 비디오 태그
Route::get('videoTagList/{tag}','Video\VideoController@videoTagList');

//모든 비디오 리스트
Route::get('videoAllTagList','Video\VideoController@videoAllTagList');

//비디오 실행창
Route::get('video/{videoID}','Video\VideoController@video');

//영상 추천수
Route::get('videoLike/{videoID}','Video\VideoController@like');


//크롤링 테스트
Route::get('/search',function(){
	return view('search');
});
Route::post('/searchJp','SearchWord\SearchWordController@searchJp');
Route::post('/searchEn','SearchWord\SearchWordController@searchEn');
Route::post('/searchEn2','SearchWord\SearchWordController@searchEn2');

//로그인 테스트
Route::post('/register-test','Member\MemberController@register');
Route::post('/login-test','Member\MemberController@login');
Route::get('/logout-test','Member\MemberController@logout');
Route::get('/memberData','Member\MemberController@memberData');
Route::get('/logout-test','Member\MemberController@logout');
Route::get('/test-form',function(){
	return view('login');
});
Route::get('pagenation','Member\MemberController@pagenation');

//100LS 결과값 확인
Route::post('/SResult','Member\MemberController@SResult');

//나의 비디오
Route::get('/myVideo','Member\MemberController@myVideo');

//나의 구독자 수
Route::post('/folower','Member\MemberController@folowerCount');

//나의 단어장
Route::get('/myWordBook','Member\MemberController@myWordBook');

//어휘 테스트 결과
Route::get('/VTestResult','Member\MemberController@VTestResult');

//출석하기
Route::get('/attendance','Member\AttendanceController@attendance');


//토큰 테스트
Route::get('/csrf-token',function(){
	return csrf_token() ;
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//도메인테스트
Route::group(['domain' => '172.26.1.125'],function(){
	Route::get('/check-auth','MemberController@checkAuth')->middleware('auth')->name('do');
});

Route::get('do',function(){
	return route('do');
});
Route::get('/check-auth','MemberController@checkAuth');

/*실행 확인용 라우트*/
Route::get('date',function(){
	return date('Y-m-d H:i:s',strtotime ("+7 days"));
});


//테스트용 url
Route::get('token','Member\MemberController@check');

Route::get('Test','Member\MemberController@test');

Route::get('videoInfo','Video\VideoController@streamingVideo');


Route::get('subtitle/{video}','Video\VideoController@subtitleView');

Route::get('subtitleEdit/{video}','Video\VideoController@subtitleEdit');

Route::get('produceSubtitle/','Video\VideoController@produceSubtitle');

Route::get('time',function(){
	return gmdate('i:s',1000 );
});

Route::get('page','Video\VideoController@videoPage');

Route::get('originTest',function(){
	return view('originUpload');
});

Route::get('test','Subtitle\SubtitleController@test');

