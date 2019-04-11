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