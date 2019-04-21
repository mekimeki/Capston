<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
/*
 * analysis = 
 *
 *
 *
 *
 */

class VoiceAnalysisController extends Controller
{   
    public $ffmpeg;

    public function __construct(){
        
        $GLOBALS['ffmpeg'] = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,   
        ));

    };

    public function analysis(){
        $datas = [];
        $analy = [];
        $projectId = 'capston';

        $files = [public_path('audio\\helloworld.wav'),public_path('audio\\hellotilt.wav')];
        // $fileName = public_path('audio\\helloworld.wav');
        // $fileName2 = public_path('audio\\hellotilt.wav');

        foreach($files as $fileName){
            $content = file_get_contents($fileName);

            $audio = (new RecognitionAudio())->setContent($content);
            
            $config = new RecognitionConfig([
                'encoding'=>AudioEncoding::LINEAR16,
                'sample_rate_hertz' => 16000,
                'language_code' => 'en-US',
            ]);

            $client = new SpeechClient();

            $response = $client->recognize($config, $audio);

            foreach ($response->getResults() as $result){
                $alternatives = $result->getAlternatives()[0];
                $datas[] = $alternatives->getTranscript();
            }

        }
        $analy = $this->comparison($datas[0],$datas[1]);
        
        return view("check",compact('datas','analy'));
    }

    function comparison($a, $b){
        $datas = [];
        $datas[] = metaphone($a);
        $datas[] = metaphone($b);
        
        $datas[] = $this->getDistance($datas[0], $datas[1]);

        return $datas;
    }

    function getMin(int $a,int $b,int $c){
        $min = $a;
        if($min > $b)
            $min = $b;
        if($min > $c)
            $min = $c;

        return $min;
    }

    function getDistance(String $a, String $b){
        $M = array();

        for($i = 0; $i < strlen($a); $i++){
            $M[$i][0] = $i;        
        }

        for($j = 0; $j < strlen($b); $j++){
            $M[0][$j] = $j;        
        }

        for($i = 1; $i < strlen($a); $i++){
            for($j = 1; $j < strlen($b); $j++){
                if(strlen($a) == strlen($b)){
                    $M[$i][$j] = $M[$i - 1][$j - 1];
                }
                else {
                    $M[$i][$j] = $this->getMin($M[$i-1][$j], $M[$i - 1][$j - 1], $M[$i][$j - 1]) + 1;
                }
            }
        }

        return "편집거리 = ".$M[strlen($a) - 1][strlen($b) - 1];
    }

    public function voiceRecord(Request $request){
        /*
        * 1. 사용자의 아이디를 받지 않았음
        * 2. 아이디를 받고, 해당하는 아이디의 폴더가 있으면 그곳에 생성 없으면 작성 후 생성
        * 3. 파일명 형식은 날짜_voice
        */

        $tmpfile = $request->all();

        $file = $tmpfile["audio"];
        
        move_uploaded_file($file, public_path('audio\\check.webm'));


        \Log::debug("type === ".gettype($this->ffmpeg));

        $faudio = $GLOBALS['ffmpeg']->open(public_path('audio\\check.webm'));
        $audio_format = new \FFMpeg\Format\Audio\Wav();

        \Log::debug("codec ==== ".$audio_format-> getAudioCodec());
        \Log::debug("codec ==== ".$audio_format-> getAudioKiloBitrate());

        $faudio->filters()->resample(16000);
        $audio_format
        ->setAudioChannels(1)
        ->setAudioKiloBitrate(192);

        $faudio->save($audio_format, public_path('audio\\check.wav'));
        
        if(\Storage::disk("local_audio")->exists('check.webm'))
        \Storage::disk("local_audio")->delete('check.webm');
        
    }

    public function voiceExtraction(Request $request){
        // $s_time = $request->input('s_time');
        // $duration = $request->input('duration');
        // $path = $request->input('pk');

        $auido_format = new \FFMpeg\Format\Audio\Wav();

        $fvideo = $GLOBALS['ffmpeg']->open(public_path('audio\\test.mp4'));

        $audio_format
        ->setAudioChannels(1)
        ->setAudioKiloBitrate(192);

        $clip = $video->clip(FFMpeg\Coordinate\TimeCode::fromSeconds($s_time), FFMpeg\Coordinate\TimeCode::fromSeconds($duration));
        
        $clip->save($audio_format, public_path('audio\\check2.wav'));
    }
}
