<?php

namespace App\Http\Controllers;

use App\Model\Video;
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
        \Log::debug('in record');
        $id = $request->input('id');
        $title = $request->input('title');
        $originText = $request->originText;
        $originDuration = $request->originDuration;

        $file = $request->file('audio');

        \Log::debug($request->all());

        $pubPath = public_path('audio\\' . $id . '\\');

        $recordPath = $pubPath . 'check.webm';

        move_uploaded_file($file, $recordPath);

        $faudio = $GLOBALS['ffmpeg']->open($recordPath);

        $audio_format = new \FFMpeg\Format\Audio\Wav();

        $faudio->filters()->resample(16000);
        $audio_format
            ->setAudioChannels(1);

        $comparePath = $pubPath . $title . "_compare.wav";

        $faudio->save($audio_format, $comparePath);

        if (\Storage::disk("local_audio")->exists($id . '/check.webm')) {
            \Storage::disk("local_audio")->delete($id . '/check.webm');
        }

        $recordText = $this->analysis($comparePath);

        $pythonPath = 'audio\\' . $id . '\\' . $title . '_compare.wav';

        $ffprobe = \FFMpeg\FFProbe::create();
        $recordDuration = $ffprobe->format($pythonPath)->get('duration');

        $durationDistance = ($originDuration - abs($originDuration - $recordDuration)) / $originDuration * 100;

        $analyDate = $this->intonation($pythonPath);

        for ($i = 0; $i < count($analyDate); $i++) {
            $analyDate[$i] = (int) $analyDate[$i];
        }

        if (count($recordText) == 0) {
            return "다시 녹음해 주세요";
        } else {
            $textComparison = $this->comparison($originText, $recordText[0]);
            \Log::debug("durationDistance ===" . $durationDistance);
            \Log::debug("textComparison ===" . $textComparison["similarity"]);

            $score = 20 + ($durationDistance * 0.2) + ($textComparison["similarity"] * 0.4);
            return ["recordAnaly" => $analyDate, "score" => (int) $score];

        }

    }

    public function voiceExtraction(Request $request)
    {
        $id = $request->input('id');
        $s_time = (float) $request->input('s_time');
        $e_time = (float) $request->input('e_time');
        $v_pk = $request->input('v_pk');
        $duration = floor($e_time - $s_time);

        \Log::debug($request->all());

        $audio_format = new \FFMpeg\Format\Audio\Wav();

        $address = video::select('v_add')->where('video_pk', $v_pk)->get()->toArray();

        $paths = explode('/', $address[0]['v_add']);

        $fileName = array_pop($paths);

        $filePath = public_path('storage\\video\\' . $id . '\\' . $fileName);

        $audio = $GLOBALS['ffmpeg']->open($filePath);

        $path = public_path('audio\\' . $id);

        if (!is_dir($path)) {
            mkdir($path);
        }

        $audio_format
            ->setAudioChannels(1)
            ->setAudioKiloBitrate(192);

        $clip = $audio->clip(\FFMpeg\Coordinate\TimeCode::fromSeconds($s_time), \FFMpeg\Coordinate\TimeCode::fromSeconds($duration));
        $clip->filters()->resample(16000);

        $path = $path . '\\' . $fileName . '_origin.wav';

        $clip->save($audio_format, $path);

        $path = 'audio\\' . $id . '\\' . $fileName . '_origin.wav';
        $analy_data = $this->intonation($path);

        for ($i = 0; $i < count($analy_data); $i++) {
            $analy_data[$i] = (int) $analy_data[$i];
        }

        return json_encode(["originText" => $this->analysis($path), "originDuration" => $duration, "analy" => $analy_data]);
    }

    public function intonation($path)
    {
        $returns = exec("python VoiceAnalysis.py " . $path);
        $returns = substr($returns, 1, -1);
        $return_arr = explode(', ', $returns);

        return $return_arr;
    }
}
