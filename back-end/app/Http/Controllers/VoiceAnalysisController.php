<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

class VoiceAnalysisController extends Controller
{
    //
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
        $tmpfile = $request->all();

        $file = $tmpfile["audio"];
        
        move_uploaded_file($file, public_path('audio\\check.webm'));

        $ffmpeg = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries'  => 'C:/ffmpeg/bin/ffmpeg.exe',
            'ffprobe.binaries' => 'C:/ffmpeg/bin/ffprobe.exe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFMpeg should use
        ));

        $faudio = $ffmpeg->open(public_path('audio\\check.webm'));
        $auido_format = new \FFMpeg\Format\Audio\Wav();
        $faudio->save($auido_format, public_path('audio\\check.wav'));
        
    }
}
