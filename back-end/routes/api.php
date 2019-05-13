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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', 'MemberController@user')->name('api.jwt.user');
});

Route::get('/video', 'Video\VideoController@index');
Route::post('/upload', 'Video\VideoController@store')->name('upload');
Route::get('submit', 'Video\VideoController@submit');

Route::post('/searchJp', 'SearchWord\SearchWordController@searchJp');
Route::post('/searchEn', 'SearchWord\SearchWordController@searchEn');

Route::get('show/{b_id}', 'QuizController@show');

Route::post('quiz', 'QuizController@english'); // 퀴즈
// Route::post('quiz', 'QuizController@result'); // 퀴즈 결과 받아오기 (점수)
Route::get('japan', 'QuizController@japanese'); // 일본어 퀴즈

// 단어장

Route::get('book/{b_id}', 'WordController@book'); // 단어장의 단어 보여주기
Route::post('deletedWord', 'WordController@destroy'); // 단어 삭제
Route::post('deletedBook', 'WordController@delete'); // 단어장 삭제
Route::post('update', 'WordController@update'); // 단어 업데이트 (암기 미암기)
Route::get('memo/{mm}', 'WordController@memo'); // 암기 미암기 단어 보여주기
Route::get('books', 'WordController@show'); // 단어장 목록 보여주기
Route::post('create', 'WordController@create'); // 단어장 추가
Route::post('title', 'WordController@edit'); // 단어장 제목 수정
Route::post('example', 'CrawlingController@example'); // 예문 뜻 크롤링
Route::post('getWord', 'WordController@store'); // 단어 받아내기

//대사장

Route::get('lineBook', 'LineController@show'); // 대사집 목록 보여주기
Route::get('line/{l_id}', 'LineController@index'); // 대사 보여주기
Route::post('deletedLine', 'LineController@destroy'); // 대사 삭제
Route::post('deletedLineBook', 'LineController@delete'); // 대사집 삭제
Route::post('createLine', 'LineController@create'); // 대사장 추가

//Route::post('pictest', 'LineController@savePicture'); // 사진 저장

Route::post('getLine', 'LineController@save'); // 대사 저장

//출석
Route::get('attend/{id}', 'AttendController@attendance');

//공개 단어장
Route::get('showBook/{id}', 'BookController@show'); // n번 단어장 보여주기
Route::get('showList', 'BookController@index'); // 단어장 목록 보여주기

Route::post('/login', 'Member\MemberController@login');
Route::get('/myVideo', 'Member\MemberController@myVideo');

Route::post('token', 'Member\MemberController@check');

//나의 비디오
Route::post('/myVideo', 'Member\MemberController@myVideo');

//100LS 결과값 확인
Route::post('/SResult', 'Member\MemberController@SResult');

//나의 구독자 수
Route::post('/folower', 'Member\MemberController@folowerCount');

//나의 단어장
Route::post('/myWordBook', 'Member\MemberController@myWordBook');

//어휘 테스트 결과
Route::post('/VTestResult', 'Member\MemberController@VTestResult');

//출석하기
Route::post('/attendance', 'Member\AttendanceController@attendance');

//구독하기
Route::post('/subscribe/{m_id}', 'Member\FolowerController@subscribe');

//구독취소
Route::post('/subscribeCancel/{m_id}', 'Member\FolowerController@subscribeCancel');

Route::post('/submitUpload', 'Video\VideoController@submitUpload');

Route::group(['middleware' => 'cors', 'prefix' => 'video'], function () {
    //영상 조회
    Route::get('/view/{video_pk}', 'Video\VideoController@view');

    //원본영상 업로드
    Route::post('/originalUpload', 'Video\VideoController@originalUpload'); //

    //스트리밍영상 업로드
    Route::post('/streamingUpload', 'Video\VideoController@streamingUpload'); //

    //스냅샷 주소
    Route::get('/snapShot/{video_pk}', 'Video\VideoController@snapShot');

    //마지막 비디오 등록
    Route::post('/enrollment', 'Video\VideoController@videoEnrollment');

    //비디오태그
    Route::get('/tag', 'Video\VideoController@videoTag');

    //나의 비디오 페이지
    Route::get('/myVideoPage', 'Video\VideoController@myVideoPage');

    //편집할 영상 주소
    Route::get('/edit/{video_pk}', 'Video\VideoController@videoEdit');

    //영상 추천하기
    Route::post('/like/{video_pk}', 'Video\LikeController@like');

    //영상 추천취소
    Route::post('/likeCancel/{video_pk}', 'Video\LikeController@likeCancel');

    //추천취소
    Route::get('/report/{video_pk}', 'Video\ReportController@report');

    //추천취소
    Route::get('/reportCancel/{video_pk}', 'Video\ReportController@reportCancel'); //

    Route::get('streaming/{video_pk}', 'Video\VideoController@streaming');

    Route::get('/viewCount', 'Video\ViewController@viewCount');

});

Route::group(['middleware' => 'cors', 'prefix' => 'videoInfo'], function () {

    Route::get('/subtitle/{video_pk}', 'Subtitle\SubtitleController@subtitleView');

    Route::get('/address/{video_pk}', 'Video\VideoPlayController@addressInfo');

    Route::get('/content/{video_pk}', 'Video\VideoPlayController@contentInfo');

    Route::get('/explain/{video_pk}', 'Video\VideoPlayController@explain');
});

Route::group(['prefix' => 'comment'], function () {
    Route::post('/add', 'Reply\ReplyController@commentAdd'); //

    Route::post('/delete', 'Reply\ReplyController@commentDelete');
});

Route::group(['prefix' => 'subtitle'], function () {

    Route::post('/originalUpload', 'Subtitle\SubtitleController@subtitleUpload'); //

    Route::post('/produce', 'Subtitle\SubtitleController@produceSubtitle');

    Route::post('/edit', 'Subtitle\SubtitleController@subtitleEdit');

    Route::get('/view/{video_pk}', 'Subtitle\SubtitleController@subtitleView');

});

Route::group(['prefix' => 'member'], function () {
    //구독하기
    Route::get('/subscribe/{m_id}', 'Member\FolowerController@subscribe');

    //구독취소
    Route::get('/subscribeCancel/{m_id}', 'Member\FolowerController@subscribeCancel');

    //출석체크
    Route::get('/attendance', 'Member\AttendanceController@attendance');

    Route::get('/SResult', 'Member\MemberController@SResult');

    Route::post('/addVoca', 'Voca\MVOController@addVoca');
});

Route::group(['prefix' => 'word'], function () {

    Route::get('/load/{video_pk}', 'Word\VideoWordController@loadWord');

    Route::get('/myBook', 'Member\MemberController@myWordBook');

    Route::get('/searchJp', 'SearchWord\SearchWordController@searchJp');

    Route::get('/searchEn', 'SearchWord\SearchWordController@searchEn');

});

Route::group(['prefix' => 'voca'], function () {

    Route::get('/search', 'Voca\VocabularyController@vocaSearch');

    Route::get('/load/{id}', 'Voca\VocabularyController@loadVoca');

    Route::post('/add', 'Voca\VocabularyController@addVoca');

    Route::post('/update', 'Voca\VocabularyController@updateVoca');

    Route::post('/insert', 'Voca\VocabularyController@insertVoca');

    Route::get('/history', 'Voca\VocabularyController@history');

});

Route::group(['prefix' => 'vocaBook'], function () {

    Route::post('/addBook', 'Voca\MemberVocaBookController@addVocaBook');

    Route::post('/updateBook', 'Voca\MemberVocaBookController@updateVocaBook');

    Route::post('/deleteBook', 'Voca\MemberVocaBookController@deleteVocaBook');

    Route::post('/addVoca', 'Voca\MVOController@addVoca');

    Route::post('/deleteVoca', 'Voca\MVOController@deleteVoca');
});

Route::post('/csrf-token', function () {
    return csrf_token();
});

//100LS
Route::post('voice/extraction', 'VoiceAnalysisController@voiceExtraction');
Route::post('voice/record', 'VoiceAnalysisController@voiceRecord');
Route::post('voice/intonation', 'VoiceAnalysisController@intonation');

//시험 결과
Route::post('testResult', 'TestResult\VocaTestResultController@getResult');
Route::post('insertResult', 'TestResult\VocaTestResultController@insertResult');

Route::post('speakResult', 'TestResult\SResultController@getResult');
