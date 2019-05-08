<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
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

    public function __construct(){
        
        $GLOBALS['ffmpeg'] = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
            'timeout'          => 3600,
            'ffmpeg.threads'   => 12,   
        ));
    }

    public function analysis($path){
        $text = [];
        $analy = [];
        $projectId = 'capston';

        \Log::debug($path);

        // $files = [$origin_path,public_path('audio\\hellotilt.wav')];

        // foreach($files as $fileName){
        //     $content = file_get_contents($fileName);

        //     $audio = (new RecognitionAudio())->setContent($content);
            
        //     $config = new RecognitionConfig([
        //         'encoding'=>AudioEncoding::LINEAR16,
        //         'sample_rate_hertz' => 16000,
        //         'language_code' => 'en-US',
        //     ]);

        //     $client = new SpeechClient();

        //     $response = $client->recognize($config, $audio);

        //     foreach ($response->getResults() as $result){
        //         $alternatives = $result->getAlternatives()[0];
        //         $datas[] = $alternatives->getTranscript();
        //     }

        // }

        $content = file_get_contents($path);

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
            $text[] = $alternatives->getTranscript();
        }

        return $text;

        // $analy = $this->comparison($datas[0],$datas[1]);
        
        // return [$analy,$datas];
        // return view("check",compact('datas','analy'));
    }

    function comparison($a, $b){
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
        
        $datas["similarity"] = (int)((strlen($metaA)+strlen($metaB))-$distance/(strlen($metaA)+strlen($metaB))*100);

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

        return $M[strlen($a) - 1][strlen($b) - 1];
    }

    public function voiceRecord(Request $request){
        /*
        * 1. 사용자의 아이디를 받지 않았음
        * 2. 아이디를 받고, 해당하는 아이디의 폴더가 있으면 그곳에 생성 없으면 작성 후 생성
        * 3. 파일명 형식은 날짜_voice
        * 4. 사용 되는 path 단순하게
        */
        // $all = $request->all();
        $file = $request->file('audio');
        // \Log::debug($all);
        $originText = $request->originText;
        // \Log::debug("originnnn".$originText);
        // $id = $all["id"];

        $id = 'a';

        move_uploaded_file($file, public_path('audio\\'.$id.'\\check.webm'));

        // \Log::debug("type === ".gettype($this->ffmpeg));

        $faudio = $GLOBALS['ffmpeg']->open(public_path('audio\\'.$id.'\\check.webm'));
        
        $audio_format = new \FFMpeg\Format\Audio\Wav();

        $faudio->filters()->resample(16000);
        $audio_format
        ->setAudioChannels(1);

        $faudio->save($audio_format, public_path('audio\\'.$id.'\\compare.wav'));
        
        if(\Storage::disk("local_audio")->exists($id.'/check.webm'))
        \Storage::disk("local_audio")->delete($id.'/check.webm');
        
        $recordText =  $this->analysis(public_path('audio\\'.$id.'\\compare.wav'));

        \Log::debug("record == ".count($recordText));
        \Log::debug("typeeee".gettype($recordText));

        if(count($recordText) == 0){
            return "다시 녹음해 주세요";
        }else{
            return $this->comparison($originText, $recordText[0]);
        }
        
    }

    public function voiceExtraction(Request $request){
        // $s_time = $request->input('s_time');
        // $duration = $request->input('duration');
        // $path = $request->input('pk');
        // $video_path = $request->v_add;
        // $id = $request->id;

        $id = 'a';
        $s_time = 1;
        $duration = 8;
        $audio_format = new \FFMpeg\Format\Audio\Wav();

        // $audio = $GLOBALS['ffmpeg']->open($video_path);

        $audio = $GLOBALS['ffmpeg']->open(public_path('audio\\test.mp4'));

        $path = public_path('audio/'.$id);

        if(!is_dir($path)){
            mkdir($path);
        }

        $audio_format
        ->setAudioChannels(1)
        ->setAudioKiloBitrate(192);
        \Log::debug('checkk'.gettype($audio_format));

        $clip = $audio->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($s_time), \FFMpeg\Coordinate\TimeCode::fromSeconds($duration));
        $clip->filters()->resample(16000);
        $path = $path.'/origin.wav';

        $clip->save($audio_format, $path);

        $originsize = fileSize($path);

        \Log::debug('size ===== '.floor($originsize*8 / 256000));

        return json_encode(["originText"=>$this->analysis($path),"originDuration"=>$duration]);
    }

    public function test(){
        if(File_exists('./../python/test.py')){
            $command = escapeshellcmd('./../python/test.py');
            ob_start();
            $output = '';
            $ret_code = '';
            $returns = exec($command, $output, $ret_code);
            \Log::debug("returnssss = ".$returns);
            
            \Log::debug("returnssss = ".count($output));
            \Log::debug("returnssss = ".$ret_code);
            
            
            $test = \Storage::disk('local_pic')->url('a/test.png');
            \Log::debug("testtttt ==== ".$test);
            echo "data ==== ".$returns;
        }else {
            return "no have...";
        }
    }
}
