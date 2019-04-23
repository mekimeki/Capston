<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', 'MemberController@user')->name('api.jwt.user');
});

Route::get('/video','Video\VideoController@index');
Route::post('/upload', 'Video\VideoController@store')->name('upload');
Route::get('submit','Video\VideoController@submit');

Route::post('/searchJp','SearchWord\SearchWordController@searchJp');
Route::post('/searchEn','SearchWord\SearchWordController@searchEn');

Route::get('quiz', 'QuizController@english');
Route::post('quiz', 'QuizController@result');

Route::get('show/{b_id}', 'QuizController@show');
Route::get('japan', 'QuizController@japanese'); 


Route::post('/login','Member\MemberController@login');
Route::get('/myVideo','Member\MemberController@myVideo');

Route::post('token','Member\MemberController@check');

//나의 비디오
Route::post('/myVideo','Member\MemberController@myVideo');

//100LS 결과값 확인
Route::post('/SResult','Member\MemberController@SResult');



//나의 구독자 수
Route::post('/folower','Member\MemberController@folowerCount');

//나의 단어장
Route::post('/myWordBook','Member\MemberController@myWordBook');

//어휘 테스트 결과
Route::post('/VTestResult','Member\MemberController@VTestResult');

//출석하기
Route::post('/attendance','Member\AttendanceController@attendance');

//구독하기
Route::post('/subscribe/{m_id}','Member\FolowerController@subscribe');

//구독취소
Route::post('/subscribeCancel/{m_id}','Member\FolowerController@subscribeCancel');

Route::post('/submitUpload','Video\VideoController@submitUpload');



Route::group(['prefix'=>'video'],function(){
	//영상 조회
	Route::get('/view/{video_pk}','Video\VideoController@view');

	//원본영상 업로드
	Route::post('/originalUpload','Video\VideoController@originalUpload');//

	//스트리밍영상 업로드
	Route::post('/streamingUpload','Video\VideoController@streamingUpload');

	//나의 비디오 페이지
	Route::get('/myVideoPage','Video\VideoController@myVideoPage');

	//영상 추천하기
	Route::post('/like/{video_pk}','Video\LikeController@like');

	//영상 추천취소
	Route::post('/likeCancel/{video_pk}','Video\LikeController@likeCancel');

	//추천취소
	Route::post('/report/{video_pk}','Video\ReportController@report');

	//추천취소
	Route::post('/reportCancel/{video_pk}','Video\ReportController@reportCancel');
	
});

Route::group(['prefix'=>'subtitle'],function(){
	Route::post('/originalUpload','Video\VideoController@subtitleUpload');//
	Route::post('/produce/','Video\VideoController@produceSubtitle');
});

Route::group(['prefix'=>'member'],function(){
	//구독하기
	Route::post('/subscribe/{m_id}','Member\FolowerController@subscribe');

	//구독취소
	Route::post('/subscribeCancel/{m_id}','Member\FolowerController@subscribeCancel');

	//출석체크
	Route::post('/attendance','Member\AttendanceController@attendance');

	Route::post('/SResult','Member\MemberController@SResult');
});