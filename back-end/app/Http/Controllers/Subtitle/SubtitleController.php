<?php
/**
 * 클래스명:                       SubtitleController
 * @package                       App\Http\Controllers\Subtitle
 * 클래스 설명:                   자막 편집 및 정보 반환
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * subtitleUpload(Request) : Request(비디오ID(video_pk),자막(subtitle) ) 편집할 영사의 원본 자막 업로드
 * subtitle(비디오ID) : 비디오ID로 자막 정보를 반환(편집,학습용 실행 공용)
 * subtitleView(비디오ID) : 비디오ID로 학습할 자막 정보를 반환
 * subtitleEdit(Request) : Request(비디오ID(video_pk),시작시간(firstTime),마지막시간(lastTime)) 편집을 실행할 영상의 자막정보를 반환
 * produceSubtitle(Request) : Request(편집된 자막 정보(data))편집된 자막 저장
 */
namespace App\Http\Controllers\Subtitle;

use App\Http\Controllers\Controller;
use App\Model\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubtitleController extends Controller
{
    //

    public function subtitleUpload(Request $request)
    {
        //return $request;
        $video = Video::find($request->video_pk);

        $subtitle = $request->video_pk . '.' . 'srt';

        $video->sub_add = asset('storage/' . $subtitle);
        $request->subtitle->storeAs('public', $subtitle);
        $video->save();
        return response()->json([
            'video_pk' => $request->video_pk,
        ]);

    }

    public function subtitle($video_pk)
    {
        $public = Storage::disk('public')->exists($video_pk . '.srt');
        $subtitle = Storage::disk('subtitle')->exists($video_pk . '.srt');
        if ($public || $subtitle) {
            if ($subtitle) {
                $arr = file(asset('storage/subtitle/' . $video_pk . '.srt'));
            } else {
                $arr = file(asset('storage/' . $video_pk . '.srt'));
            }
            //file 꺼내기
            $arr_total = array(); //array
            $num = 0; //
            $check = (int) $arr[0] + 1; //first number check
            //return $arr;
            $arr_total[$num] = ""; //total array;
            ///1 for
            for ($i = 0; $i < count($arr); $i++) {
                $arr[$i] = trim($arr[$i]); //
                if ($arr[$i] == $check) {
                    $num++;
                    $arr_total[$num] = "";
                    $check++;
                }
                if ($arr[$i] != "") {
                    $arr_total[$num] = $arr_total[$num] . "#" . $arr[$i];
                }
            }
            //2 for
            $arr_total_json = array();
            for ($i = 0; $i < count($arr_total); $i++) {
                $arr_total[$i] = substr($arr_total[$i], 1);
                $arr_total_create[$i] = explode("#", $arr_total[$i]);
            }
            //return $arr_total_create;
            //video current Time 은 초 단위이다.
            for ($i = 0; $i < count($arr_total_create); $i++) {
                $arr_total_create[$i][1] = explode("--> ", $arr_total_create[$i][1]);
                for ($s = 0; $s < 2; $s++) {
                    $time = explode(":", $arr_total_create[$i][1][$s]);
                    $time[0] = (int) $time[0] * 60 * 60; //시
                    $time[1] = (int) $time[1] * 60; //분
                    $time[2] = explode(",", $time[2]); //초
                    $time[2][0] = (int) $time[2][0]; //밀리세컨드
                    $arr_total_create[$i][1][$s] = $time[0] + $time[1] + $time[2][0] + (int) $time[2][1] / 1000;
                }
            }

            //3 for
            $total_word = array();
            $total = array();
            for ($i = 0; $i < count($arr_total_create); $i++) {
                $total_word[$i] = "";
                for ($s = 2; $s < count($arr_total_create[$i]); $s++) {
                    $total_word[$i] = $total_word[$i] . "\n" . $arr_total_create[$i][$s];
                }
                array_splice($arr_total_create[$i], 2, count($arr_total_create[$i]));
                $arr_total_create[$i][2] = $total_word[$i];
            }

            //return $arr_total_create[0][1][0];
            return $arr_total_create;
        } else {
            return 'none subtitle!!';
        }
    }

    public function subtitleView($video_pk)
    {
        $subtitle = $this->subtitle($video_pk);
        return $subtitle;
        return response()->json(['subtitle' => $subtitle]);
    }

    public function subtitleEdit(Request $request)
    { //$firstTime,$lastTime

        $firstTime = $request->firstTime;
        $lastTime = $request->lastTime;
        $video_pk = $request->video_pk;

        $originalSumbit = $this->subtitle($video_pk);
        //return '!!';
        $subtitle = array();
        $num = 0;
        for ($i = 0; $i < count($originalSumbit); $i++) {
            if (empty($subtitle) && $originalSumbit[$i][1][0] > $firstTime) {
                $originalSumbit[$i][1][0] -= $firstTime;
                $originalSumbit[$i][1][1] -= $firstTime;
                $subtitle[$num] = $originalSumbit[$i];
                $num++;
            } else if (!empty($subtitle) && $originalSumbit[$i][1][0] < $lastTime) {
                $originalSumbit[$i][1][0] -= $firstTime;
                $originalSumbit[$i][1][1] -= $firstTime;
                $subtitle[$num] = $originalSumbit[$i];
                $num++;
            } else if ($originalSumbit[$i][1][0] > $lastTime) {
                return response()->json([
                    'subtitle' => $subtitle,
                ]);
            }

        }
        return response()->json(['subtitle' => $subtitle]);
    }

    public function produceSubtitle(Request $request)
    { //Request $request

        $data = $request->data;
        $data = json_decode($data, true);

        //return $request->video_pk;
        $video_pk = $request->video_pk; //

        \Log::debug("check1");

        if ($data) {
            \Log::debug("cccc");
            $txt = "";
            for ($i = 0; $i < count($data); $i++) {

                if (is_float($data[$i]['firstTime'])) {
                    $msf = explode('.', $data[$i]['firstTime']);
                    if (isset($msf[1])) {$msf[1] = 000;}
                    $msf[1] = substr($msf[1], 0, 3);
                } else {
                    $msf[1] = 000;
                }

                $data[$i]['firstTime'] = gmdate('H:i:s,', $data[$i]['firstTime']) . $msf[1]; //

                if (is_float($data[$i]['lastTime'])) {
                    $msl = explode('.', $data[$i]['lastTime']);
                    $msl[1] = substr($msl[1], 0, 3);
                    if (isset($msl[1])) {$msl[1] = 000;}
                } else {
                    $msl[1] = 000;
                }

                $data[$i]['lastTime'] = gmdate('H:i:s,', $data[$i]['lastTime']) . $msl[1]; //.$msl[1]

                $txt = $txt . ($i + 1) . "\r\n" . $data[$i]['firstTime'] . " --> " . $data[$i]['lastTime'] . "\r\n" . $data[$i]['textArea'] . "\r\n\r\n";

            }
            \Log::debug("check3");
            Storage::disk('subtitle')->put($video_pk . '.srt', $txt);
            Storage::disk('public')->delete($video_pk . '.srt');
            $video = Video::find($video_pk);
            $video->sub_add = asset('storage/subtitle/' . $video_pk . '.srt');
            $video->save();
            return response()->json([
                'messages' => 'subtitle edit success!!',
                'video_pk' => $video_pk,
            ]);
        } else {
            return response()->json([
                'messages' => 'subtitle edit fail!!',
            ]);
        }
    }

    public function test()
    {
        $text = "1" . "\r\n" . "00:00:00,920 --> 00:00:05,601" . "\r\n" . "ㅎㄹㄹㄹㄹ" . "\r\n\r\n" .
            "2" . "\r\n" . "00:00:01,920 --> 00:00:06,601" . "\r\n" . "ddddddd" . "\r\n\r\n" .
            "3" . "\r\n" . "00:00:02,920 --> 00:00:07,601" . "\r\n" . "43244" . "\r\n\r\n" .
            "4" . "\r\n" . "00:00:03,920 --> 00:00:08,601" . "\r\n" . "dfsdfs" . "\r\n\r\n" .
            "5" . "\r\n" . "00:00:04,920 --> 00:00:09,644" . "\r\n" . "ddddddfs" . "\r\n\r\n";
        Storage::disk('subtitle')->put('999.srt', $text);
    }

}
