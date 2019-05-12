<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Snoopy;
use App\Model\Word;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $snoopy;
    public function __construct()
    {
        $this->snoopy = new Snoopy;
    }

    public function english(Request $request)
    {
        $id = 1;
        $ran_box = $request->input('ran_box[]');

        $vocas = word::where('wbook_pk', $id)->select('w_nm AS word')->groupBy('w_nm')->get()->toArray();

        if (empty($ran_box)) {
            $ran_box = [];
        }

        $random = random_int(0, count($vocas) - 1);

        while (in_array($random, $ran_box)) {
            $random = random_int(0, $vocas->count() - 1);
        }

        array_push($ran_box, $random);

        $word = array_splice($vocas, $random, 1);

        \Log::debug($vocas);
        \Log::debug($word);

        $randoms = array_rand($vocas, 3);
        $choiceRandom = random_int(0, 3);

        $choices = [$vocas[$randoms[0]], $vocas[$randoms[1]], $vocas[$randoms[2]]];

        $arr_front = array_slice($choices, 0, $choiceRandom);
        $arr_end = array_slice($choices, $choiceRandom);

        \Log::debug($choiceRandom);
        $arr_front[] = $word[0];
        \Log::debug($arr_front);
        $choices = array_merge($arr_front, $arr_end);

        \Log::debug($vocas);

        $this->snoopy->fetch('https://m.dic.daum.net/search.do?q=' . $word[0]['word']);
        $result = $this->snoopy->results;

        $matchFlag = preg_match('/<ul class="list_search">(.*?)<\/ul>/is', $result, $mean);
        /*태그만제거*/
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/ul>/i", '', $mean);
        $mean = preg_replace("/<\/li>/", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/span>/", '', $mean);
        $mean = preg_replace("/(<daum[^>]*>)/i", '', $mean);
        $mean = preg_replace("/(<\/daum:word>)/", '', $mean);
        $mean = preg_replace("/[0-9]./", '', $mean);
        $mean = preg_replace("/\t|\n/", '', $mean);

        if ($matchFlag) {
            $array = explode('<li>', $mean[0]);
            array_shift($array);

            $back = ["ques" => $array, "choice" => $choices, "ans" => $choiceRandom];
            $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            return $back;
        } else {
            return '검색 결과가 없습니다.';
        }

    }

    public function japanese()
    {
        $id = 2;
        $vocas = word::where('wbook_pk', $id)->select('w_nm')->inRandomOrder()->take(4)->get();
        $random = random_int(0, $vocas->count() - 1);
        $quiz = $vocas->slice($random, 1);
        $this->snoopy->fetch('https://alldic.daum.net/search.do?q=' . $quiz[$random]->w_nm . '&dic=jp');
        $result = $this->snoopy->results;

        $matchFlag = preg_match('/<ul class="list_search">(.*?)<\/ul>/is', $result, $mean);
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/ul>/i", '', $mean);
        $mean = preg_replace("/<\/li>/", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/span>/", '', $mean);
        $mean = preg_replace("/(<daum[^>]*>)/i", '', $mean);
        $mean = preg_replace("/(<\/daum:word>)/", '', $mean);
        $mean = preg_replace("/[0-9]./", '', $mean);
        $mean = preg_replace("/\t|\n/", '', $mean);

        if ($matchFlag) {
            $array = explode('<li>', $mean[0]);
            array_shift($array);

            $back = ["ques" => $array, "choice" => $vocas, "ans" => $random];
            $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            return $back;
        } else {
            return '검색 결과가 없습니다.';
        }

    }

    public function result(Request $request)
    {
        $results = $request->input('results');

        $result = (int) $results;
        \Log::debug(gettype($result) . $result);

        \DB::insert('insert into votest_result_tb (m_id, test_add, test_score) values (?, ?, ?)', [1, "numnum", $result]);

        return "저장되었습니다";
    }

}
