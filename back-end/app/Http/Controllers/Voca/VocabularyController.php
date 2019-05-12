<?php
/**
 * 클래스명:                       VocabularyController
 * @package                       App\Http\Controllers\Voca
 * 클래스 설명:                   영상 업로드시 문법 및 단어 추가
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 5월 4일
 * 수정일:                        2019년 5월 6일
 * 함수 목록
 * addVoca(Request) : Request(비디오ID(video_pk),문법(content),단어(word)) 영상 업로드 시 문법 및 단어 추가
 * vocaSearch(Request) : Request(문법(voca)) 문법검색
 * loadVoca(비디오ID) : 비디오ID로 해당 비디오와 관련된 문법정보 반환
 * updateVoca(Request) : Request(문법ID(vo_pk),문법(voca),설명(explain)) 문법 정보 수정
 * insertVoca(Request) : Request(문법(voca),설명(explain)) 업로드된 영상의 문법정보 추가
 */
namespace App\Http\Controllers\Voca;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Word\VideoWordController;
use App\Model\VG;
use App\Model\Vocabulary;
use Illuminate\Http\Request;

class VocabularyController extends Controller
{

    public function addVoca(Request $request)
    {
        //$request;
        $wordController = new VideoWordController;
        $video_pk = $request->video_pk;
        $content = json_decode($request->content, true);
        $word = json_decode($request->word, true);
        $wordController->addWord($word, $video_pk);

        if (count($content) > 0) {
            for ($i = 0; $i < count($content); $i++) {
                if ($content[$i]['vo_pk'] == false) {
                    //$check = Vocabulary::where('voca',$voca)->where('explain',$explain)->get();
                    $check = Vocabulary::where([
                        'voca' => $content[$i]['voca'],
                        'explain' => $content[$i]['explain'],
                    ])->get();
                    if (count($check) == 0) {
                        $data = new Vocabulary;
                        $data->fill([
                            'voca' => $content[$i]['voca'],
                            'explain' => $content[$i]['explain'],
                        ]);
                        $data->save();
                        //return $data;
                        VG::create([
                            'video_pk' => $video_pk,
                            'gidiom_pk' => $data->vo_pk,
                            'start_time' => $content[$i]['firstTime'],
                            'end_time' => $content[$i]['firstTime'] + 2,
                        ]);
                    } else {
                        VG::create([
                            'video_pk' => $video_pk,
                            'gidiom_pk' => $check[0]['vo_pk'],
                            'start_time' => $content[$i]['firstTime'],
                            'end_time' => $content[$i]['firstTime'] + 2,
                        ]);
                    }
                } else {
                    VG::create([
                        'video_pk' => $video_pk,
                        'gidiom_pk' => $content[$i]['vo_pk'],
                        'start_time' => $content[$i]['firstTime'],
                        'end_time' => $content[$i]['firstTime'] + 2,
                    ]);
                }
            }
        }

        return 'success';

    }

    public function vocaSearch(Request $request)
    {
        //return $request;
        $search = $request->voca;

        $result = Vocabulary::where('voca', 'like', '%' . $search . '%')->get();
        if (count($result) == 0) {
            return response()->json([
                'indata' => false,
            ]);
        } else {
            return response()->json([
                'data' => $result,
                'indata' => true,
            ]);
        }
    }

    public function loadVoca($video_pk)
    {
        $voca = VG::where('video_pk', $video_pk)->with('vocabulary')->orderby('start_time', 'asc')->get();
        //return $voca;
        $result = array();
        //return $voca[0]['start_time'];
        for ($i = 0; $i < count($voca); $i++) {
            $vocabulary = $voca[$i]['vocabulary'];
            $result[$i] = [
                (string) ($i + 1),
                [
                    $voca[$i]['start_time'],
                    $voca[$i]['end_time'],
                ],
                [
                    $vocabulary['voca'],
                    $vocabulary['explain'],
                ],
                $vocabulary['vo_pk'],
            ];
        }
        return $result;
        return response()->json([
            'voca' => $result,
        ]);
    }

    public function updateVoca(Request $request)
    {
        /*
        $member_pk = $this->check->check($request);

        if(isset($member_pk[0]['messages']) ){
        return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }
         */
        //VG

        $video_pk = $request->video_pk;
        $vo_pk = $request->vo_pk;
        $voca = $request->title;
        $explain = $request->explain;
        $time = $request->time;
        //$check = Vocabulary::where('voca',$voca)->where('explain',$explain)->get();

        $check = Vocabulary::where([
            'voca' => $voca,
            'explain' => $explain,
        ])->first();

        if (!isset($check)) {

            $vocabulary = Vocabulary::create([
                'voca' => $voca,
                'explain' => $explain,
            ]);

            $videoVoca = VG::where([
                'video_pk' => $video_pk,
                'gidiom_pk' => $vo_pk,
                'start_time' => $time,
            ])
                ->update(['gidiom_pk' => $vocabulary->vo_pk]);
            $vo_pk = $vocabulary->vo_pk;
        } else {

            $videoVoca = VG::where([
                'video_pk' => $video_pk,
                'gidiom_pk' => $vo_pk,
                'start_time' => $time,
            ])
                ->update(['gidiom_pk' => $check['vo_pk']]);

            $vo_pk = $check['vo_pk'];

        }

        return response()->json([
            'message' => 'update success!!',
            'vo_pk' => $vo_pk,
        ]);

    }

    public function history(Request $request)
    {

        $voca = $request->voca;
        $result = Vocabulary::where([
            'voca' => $voca,
        ])->get();
        return $result;
    }

    public function insertVoca(Request $request)
    {
        /*
        $member_pk = $this->check->check($request);

        if(isset($member_pk[0]['messages']) ){
        return response()->json([ 'messages'=>$member_pk[0]['messages'] ],200);
        }
         */

        $voca = $request->voca;
        $explain = $request->explain;
        $time = $request->time;
        $video_pk = $request->video_pk;
        $vocaCheck = Vocabulary::where([
            'voca' => $voca,
            'explain' => $explain,
        ])->first();

        //return $explain;
        if (!isset($vocaCheck) && isset($voca) && isset($explain) && isset($time) && isset($video_pk)) {
            $vocabulary = Vocabulary::create([
                'voca' => $voca,
                'explain' => $explain,
            ]);

            VG::create([
                'video_pk' => $video_pk,
                'gidiom_pk' => $vocabulary->vo_pk,
                'start_time' => $time,
                'end_time' => $time + 3,
            ]);
            return response()->json([
                'result' => 1,
                'message' => 'successfully added(1)',
            ]);
        } else if (isset($vocaCheck) && isset($voca) && isset($explain) && isset($time) && isset($video_pk)) {
            VG::create([
                'video_pk' => $video_pk,
                'gidiom_pk' => $vocaCheck->vo_pk,
                'start_time' => $time,
                'end_time' => $time + 3,
            ]);
            return response()->json([
                'result' => 1,
                'message' => 'successfully added(2)',
            ]);
        } else {
            return response()->json([
                'result' => 0,
                'message' => 'none data',
            ]);
        }

    }
}
