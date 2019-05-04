<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Snoopy;
use Illuminate\Http\Request;

class CrawlingController extends Controller
{
    //
    public $snoopy;
    public function __construct()
    {
        $this->snoopy = new Snoopy;
    }

    public function searchJpT(Request $request)
    {
        $word = $request->word;
        $this->snoopy->fetch('https://alldic.daum.net/search.do?q=' . $word . '&dic=jp');
        $result = $this->snoopy->results;

        //
        preg_match('/<strong class="tit_cleansch(.*?)<span class=\"img_comm ico_voice\">/is', $result, $kanji);
        $kanji = preg_replace("/<strong[^>]*>/i", '', $kanji);
        $kanji = preg_replace("/<a[^>]*>/i", '', $kanji);
        $kanji = preg_replace("/<span[^>]*>/i", '', $kanji);
        $kanji = preg_replace("/<span[^>]*>/i", '', $kanji);
        $kanji = preg_replace('/\s+/', ' ', $kanji);
        //
        preg_match('/<ul class="list_search">(.*?)<\/ul>/is', $result, $mean);
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<li[^>]*>/i", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<daum:word[^>]*>/i", '', $mean);
        $mean = preg_replace('/\s+/', '', $mean);
        //
        if ($mean && $kanji) {
            return $kanji[0] . ':' . $mean[0];
        } else {
            return '검색 결과가 없습니다.';
        }
    }

    public function searchEn(Request $request)
    {
        $word = $request->word;
        $this->snoopy->fetch('https://alldic.daum.net/search.do?q=' . $word); ////https://alldic.daum.net/search.do?q=text&dic=eng
        $result = $this->snoopy->results;

        //
        preg_match('/<span class="txt_emph1">(.*?)<\/span>/is', $result, $pronunciation);
        /*태그만제거*/
        $pronunciation = preg_replace("/<span[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace('/\s+/', ' ', $pronunciation);

        //

        preg_match('/<ul class="list_search">(.*?)<\/ul>/is', $result, $mean);
        /*태그만제거*/
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<li[^>]*>/i", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace('/\s+/', '', $mean);
        if ($pronunciation && $mean) {
            return $pronunciation[0] . ' : ' . $mean[0];
        } else {
            return '검색 결과가 없습니다.';
        }
    }

    public function searchJp(Request $request)
    {
        $word = $request->word;
        $this->snoopy->fetch('https://alldic.daum.net/search.do?q=' . $word); ////https://alldic.daum.net/search.do?q=text&dic=eng
        $result = $this->snoopy->results;

        preg_match('/<div class="card_word #word #jp">(.*?)<\/ul>/is', $result, $pronunciation); //<\/ul>//<span class="desc_listen">//<\/strong>

        /*특정 텍스트 제거*/
        $pronunciation = str_replace('일본어사전', '', $pronunciation);
        $pronunciation = str_replace('주요 검색어', '', $pronunciation);

        /*태그 와 태그 내용 통째로 제거*/
        $pronunciation = preg_replace("!<ul(.*?)<\/ul>!is", "", $pronunciation);
        $pronunciation = preg_replace("!<span class=\"desc_listen\"(.*?)<\/span>!is", "", $pronunciation);
        $pronunciation = preg_replace("!<span class=\"img_comm\"(.*?)<\/span>!is", "", $pronunciation);

        /*태그만제거*/
        $pronunciation = preg_replace("/<div[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace("/<ul[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace("/<li[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace("/<strong[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace("/<a[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace("/<span[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace("/<h4[^>]*>/i", '', $pronunciation);
        $pronunciation = preg_replace('/\s+/', '', $pronunciation);

        /////

        preg_match('/<div class="card_word #word #jp">(.*?)<\/ul>/is', $result, $mean);
        /*특정 텍스트 제거*/
        $mean = str_replace('일본어사전', '', $mean);
        $mean = str_replace('주요 검색어', '', $mean);

        /*태그 와 태그 내용 통째로 제거*/
        $mean = preg_replace("!<a(.*?)<\/a>!is", "", $mean);

        /*태그만제거*/
        $mean = preg_replace("/<div[^>]*>/i", '', $mean);
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<li[^>]*>/i", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<daum:word[^>]*>/i", '', $mean);
        $mean = preg_replace("/<h4[^>]*>/i", '', $mean);
        $mean = preg_replace("/<strong[^>]*>/i", '', $mean);
        $mean = preg_replace('/\s+/', '', $mean);

        if ($pronunciation && $mean) {
            return $pronunciation[0] . ' : ' . $mean[0];
        } else {
            return '검색 결과가 없습니다.';
        }

    }

    public function example(Request $request) // 예문

    {
        $word = $request->input('word');
        $this->snoopy->fetch('https://m.dic.daum.net/search.do?q=' . $word . '&dic=ee&search_first=Y');
        $result = $this->snoopy->results;
        //\Log::debug($result);
        $matchFlag = preg_match('/<ul class="list_example sound_example">(.*?)<\/ul>/is', $result, $mean);
        /*태그만제거*/
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/ul>/i", '', $mean);
        $mean = preg_replace("/<li[^>]*>/i", '', $mean);
        //$mean = preg_replace("/<\/li>/", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/span>/", '', $mean);
        $mean = preg_replace("/<daum:word[^>]*>/i", '', $mean);
        $mean = preg_replace("/<daum:collocate[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/daum:collocate[^>]*>/i", '', $mean);
        $mean = preg_replace("/(<\/daum:word>)/", '', $mean);

        $mean = preg_replace("/<a[^>]*>/i", '', $mean);
        //$mean = preg_replace("/<\/a>/", '', $mean);
        $mean = preg_replace("/<div[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/div>/", '', $mean);
        $mean = preg_replace("/\t|\n/", '', $mean);
        $mean = preg_replace("/<\/li>/", '', $mean);
        $mean = trim($mean[0]);
        if ($matchFlag) {
            $array = explode("</a>", $mean);
            $arrays = [];
            for ($i = 0; $i < count($array) - 1; $i++) {
                $arrays[$i] = trim($array[$i]);

                if ($i % 2 != 0) {
                    $arrays[$i] = rtrim($arrays[$i], "\ 소리듣기");
                }

            }
            \Log::debug($arrays);
            $arrays = json_encode($arrays, JSON_UNESCAPED_UNICODE);
            return $arrays;
        } else {
            return '검색 결과가 없습니다.';
        }
    }

    public function mean(Request $request) // 단어 뜻

    {
        $word = $request->input('word');
        $this->snoopy->fetch('https://m.dic.daum.net/search.do?q=' . $word);
        $result = $this->snoopy->results;

        $matchFlag = preg_match('/<ul class="list_search">(.*?)<\/ul>/is', $result, $mean);
        /*태그만제거*/
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/ul>/i", '', $mean);
        //$mean = preg_replace("/<li[^>]*>/i", '', $mean); // 좀 더 보기 편하게 해줌
        $mean = preg_replace("/<\/li>/", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/span>/", '', $mean);
        $mean = preg_replace("/<daum:word[^>]*>/i", '', $mean);
        $mean = preg_replace("/(<\/daum:word>)/", '', $mean);
        $mean = preg_replace("/<a[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/a>/", '', $mean);
        $mean = preg_replace("/<\/div>/", '', $mean);
        $mean = preg_replace("/\t|\n/", '', $mean);

        if ($matchFlag) {
            $array = explode('<li>', $mean[0]);
            array_shift($array);
            \Log::debug($array);
            $array = json_encode($array, JSON_UNESCAPED_UNICODE);
            return $array;
        } else {
            return '검색 결과가 없습니다.';
        }
    }

    public function wordExample(Request $request)
    {
        $word = $request->input('word');
        return $this->example($word);
    }

    public function wordMean(Request $request)
    {
        $word = $request->input('word');
        return $this->mean($word);
    }

}
