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


Route::get('/', function () {
    return view('welcome');
});

//<<<<<<< Updated upstream
//비디오테스트
Route::group(['middleware'=>['auth']],function(){
	
});
Route::get('/video','VideoController@index');
Route::get('/uploader', 'VideoController@uploader')->name('uploader');
Route::post('/upload', 'VideoController@store')->name('upload');
Route::get('submit','VideoController@submit');
Route::get('/video-cut','VideoController@videoCut');
Route::get('/ffmpeg',function(){
	return view('ffmpeg');
});

//크롤링 테스트
Route::get('/search',function(){
	return view('search');
});
Route::post('/searchJp','CrawlingController@searchJp');
Route::post('/searchEn','CrawlingController@searchEn');

//로그인 테스트
Route::post('/register-test','MemberController@register');
Route::post('/login-test','MemberController@login');
Route::get('/logout-test','MemberController@logout');
Route::get('/memberData','MemberController@memberData');
Route::get('/test-form',function(){
	return view('login');
});
Route::get('pagenation','MemberController@pagenation');

//100LS 결과값 확인
Route::get('/SResult','MemberController@SResult');

//나의 비디오
Route::get('/myVideo','MemberController@myVideo');

//나의 구독자 수
Route::get('/folower','MemberController@folowerCount');

//나의 단어장
Route::get('/myWordBook','MemberController@myWordBook');

//어휘 테스트 결과
Route::get('/VTestResult','MemberController@VTestResult');

//토큰 테스트
Route::get('/get-token',function(){
	return csrf_token() ;
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//도메인테스트
Route::group(['domain' => '172.26.3.246'],function(){
	Route::get('/check-auth','MemberController@checkAuth')->middleware('auth')->name('do');
});
Route::get('do',function(){
	return route('do');
});
Route::get('/check-auth','MemberController@checkAuth');


//음성 분석 부분

Route::get('voice/analysis', [
    'as' => 'voice.analy',
    'uses' => 'VoiceAnalysisController@analysis'
]);

Route::post('voice/record',[
	'as' => 'voice.record',
	'uses' => 'VoiceAnalysisController@voiceRecord'
]);

Route::post('voice/extract', 'VoiceAnalysisController@voiceExtraction');

Route::get('voice/test', 'VoiceAnalysisController@test');

// Route::get('quiz', 'QuizController@index');
// Route::get('solution', 'QuizController@show')->name('quiz');