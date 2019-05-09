<?php

namespace App\Http\Controllers;

use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1\SpeechClient;
use Illuminate\Http\Request;

/*
 * analysis = GCP - STT -> comparison()
 * comparison = get metaphone and minimum distance
 * getMin = get min value
 * getDistance = get text from original and recorded wave
 * voiceRecord = formating recorded blob to wav
 * voiceExtraction = get origin wav from video
 */

class VoiceAnalysisController extends Controller
{
    public $ffmpeg;

    public function __construct()
    {

        $GLOBALS['ffmpeg'] = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries' => 'C:/ffmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
            'timeout' => 3600,
            'ffmpeg.threads' => 12,
        ));
    }

    public function analysis($path)
    {
        $text = [];
        $analy = [];
        $projectId = 'capston';

        \Log::debug($path);

        $content = file_get_contents($path);

        $audio = (new RecognitionAudio())->setContent($content);

        $config = new RecognitionConfig([
            'encoding' => AudioEncoding::LINEAR16,
            'sample_rate_hertz' => 16000,
            'language_code' => 'en-US',
        ]);

        $client = new SpeechClient();

        $response = $client->recognize($config, $audio);

        foreach ($response->getResults() as $result) {
            $alternatives = $result->getAlternatives()[0];
            $text[] = $alternatives->getTranscript();
        }

        return $text;

    }

    public function comparison($a, $b)
    {
        $datas = [];
        $metaA = metaphone($a);
        $metaB = metaphone($b);
        $distance = $this->getDistance($metaA, $metaB);

        # metaphone a,b
        $datas["metaA"] = $metaA;
        $datas["metaB"] = $metaB;

        # insult minimum distance
        $datas["distance"] = $distance;

        # similarity calculation

        $datas["similarity"] = (int) ((strlen($metaA) + strlen($metaB)) - $distance / (strlen($metaA) + strlen($metaB)) * 100);

        return $datas;
    }

    public function getMin(int $a, int $b, int $c)
    {
        $min = $a;
        if ($min > $b) {
            $min = $b;
        }

        if ($min > $c) {
            $min = $c;
        }

        return $min;
    }

    public function getDistance(String $a, String $b)
    {
        $M = array();

        for ($i = 0; $i < strlen($a); $i++) {
            $M[$i][0] = $i;
        }

        for ($j = 0; $j < strlen($b); $j++) {
            $M[0][$j] = $j;
        }

        for ($i = 1; $i < strlen($a); $i++) {
            for ($j = 1; $j < strlen($b); $j++) {
                if (strlen($a) == strlen($b)) {
                    $M[$i][$j] = $M[$i - 1][$j - 1];
                } else {
                    $M[$i][$j] = $this->getMin($M[$i - 1][$j], $M[$i - 1][$j - 1], $M[$i][$j - 1]) + 1;
                }
            }
        }

        return $M[strlen($a) - 1][strlen($b) - 1];
    }

    public function voiceRecord(Request $request)
    {
        /*
         * 1. 사용자의 아이디를 받지 않았음
         * 2. 아이디를 받고, 해당하는 아이디의 폴더가 있으면 그곳에 생성 없으면 작성 후 생성
         * 3. 파일명 형식은 날짜_voice
         * 4. 사용 되는 path 단순하게
         */
        $file = $request->file('audio');
        $originText = $request->originText;

        $id = 'a';

        move_uploaded_file($file, public_path('audio\\' . $id . '\\check.webm'));

        $faudio = $GLOBALS['ffmpeg']->open(public_path('audio\\' . $id . '\\check.webm'));

        $audio_format = new \FFMpeg\Format\Audio\Wav();

        $faudio->filters()->resample(16000);
        $audio_format
            ->setAudioChannels(1);

        $faudio->save($audio_format, public_path('audio\\' . $id . '\\compare.wav'));

        if (\Storage::disk("local_audio")->exists($id . '/check.webm')) {
            \Storage::disk("local_audio")->delete($id . '/check.webm');
        }

        $recordText = $this->analysis(public_path('audio\\' . $id . '\\compare.wav'));

        \Log::debug("record == " . count($recordText));
        \Log::debug("typeeee" . gettype($recordText));

        if (count($recordText) == 0) {
            return "다시 녹음해 주세요";
        } else {
            return $this->comparison($originText, $recordText[0]);
        }

    }

    public function voiceExtraction(Request $request)
    {

        // $id = 'a';
        // $s_time = 1;
        // $duration = 8;
        $id = $request->input('id');
        $s_time = $request->input('s_time');
        $e_time = $request->input('e_time');
        $duration = s_time-e_time;

        $audio_format = new \FFMpeg\Format\Audio\Wav();

        $audio = $GLOBALS['ffmpeg']->open(public_path('audio\\test.mp4'));

        $path = public_path('audio\\' . $id);

        if (!is_dir($path)) {
            mkdir($path);
        }

        $audio_format
            ->setAudioChannels(1)
            ->setAudioKiloBitrate(192);
        \Log::debug('checkk' . gettype($audio_format));

        $clip = $audio->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($s_time), \FFMpeg\Coordinate\TimeCode::fromSeconds($duration));
        $clip->filters()->resample(16000);
        $path = $path . '\\origin.wav';

        $clip->save($audio_format, $path);

        $path = 'audio\\'.$id.'\\origin.wav';
        $analy_data = $this->intonation($path);
        return json_encode(["originText" => $this->analysis($path), "originDuration" => $duration, "analy"=>$analy_data]);
    }

    public function intonation($path)
    {
        $returns = exec("python VoiceAnalysis.py " . $path);
        $returns = substr($returns, 1, -1);
        $return_arr = explode(', ', $returns);

        return $return_arr;
    }
}
