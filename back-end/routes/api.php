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
Route::get('unauthorized', function() {
    return response()->json([
        'status' => 'error',
        'message' => 'Unauthorized'
    ], 401);
})->name('api.jwt.unauthorized');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user', 'MemberController@user')->name('api.jwt.user');
});

Route::post('/upload', 'VideoController@store');
Route::get('/video','VideoController@index');
//Route::get('/uploader', 'VideoController@uploader')->name('uploader');
Route::post('/upload', 'VideoController@store')->name('upload');
Route::get('submit','VideoController@submit');

Route::post('/searchJp','CrawlingController@searchJp');
Route::post('/searchEn','CrawlingController@searchEn');

Route::get('quiz', 'QuizController@english'); // 퀴즈
Route::post('quiz', 'QuizController@result'); // 퀴즈 결과 받아오기 (점수)
Route::get('japan', 'QuizController@japanese'); // 일본어 퀴즈

// 단어장

Route::get('book/{b_id}', 'WordController@book'); // 단어장의 단어 보여주기
Route::post('deletedWord', 'WordController@destroy'); // 단어 삭제
Route::post('update', 'WordController@update'); // 단어 업데이트 (암기 미암기)
Route::get('index', 'WordController@index');
Route::get('memo/{mm}', 'WordController@memo'); // 암기 미암기 단어 보여주기
Route::get('books', 'WordController@show'); // 단어장 목록 보여주기

//대사장

Route::get('lineBook', 'LineController@show'); // 대사집 목록 보여주기
Route::get('line/{l_id}', 'LineController@index'); // 대사 보여주기
Route::get('deletedLine', 'LineController@destroy'); // 대사 삭제

//출석

Route::get('attend/{id}', 'AttendController@attendance');

