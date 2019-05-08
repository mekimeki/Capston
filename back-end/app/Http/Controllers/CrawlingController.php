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
		$word = $request->input('clickWord');
        $this->snoopy->fetch('https://m.dic.daum.net/search.do?q='.$word.'&dic=ee&search_first=Y');
        $result = $this->snoopy->results;
        //\Log::debug($result);
        $matchFlag = preg_match('/<ul class="list_example sound_example">(.*?)<\/ul>/is', $result, $exapmle);
        /*태그만제거*/
        $exapmle = preg_replace("/<ul[^>]*>/i", '', $exapmle);
        $exapmle = preg_replace("/<\/ul>/i", '', $exapmle);
        $exapmle = preg_replace("/<li[^>]*>/i", '', $exapmle);
        //$mean = preg_replace("/<\/li>/", '', $mean);
        $exapmle = preg_replace("/<span[^>]*>/i", '', $exapmle);
        $exapmle = preg_replace("/<\/span>/", '', $exapmle);
        $exapmle = preg_replace("/<daum:word[^>]*>/i", '', $exapmle);
        $exapmle = preg_replace("/<daum:collocate[^>]*>/i", '', $exapmle);
        $exapmle = preg_replace("/<\/daum:collocate[^>]*>/i", '', $exapmle);
        $exapmle = preg_replace("/(<\/daum:word>)/", '', $exapmle);

        $exapmle = preg_replace("/<a[^>]*>/i", '', $exapmle);
        //$mean = preg_replace("/<\/a>/", '', $mean);
        $exapmle = preg_replace("/<div[^>]*>/i", '', $exapmle);
        $exapmle = preg_replace("/<\/div>/", '', $exapmle);
        $exapmle = preg_replace("/\t|\n/", '', $exapmle);
        $exapmle = preg_replace("/<\/li>/", '', $exapmle);
		$exapmle = trim($exapmle[0]);

		//////////////////

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
            $array = explode("</a>", $exapmle);
            $arrays = [];
            for ($i = 0; $i < count($array) - 1; $i++) {
                $arrays[$i] = trim($array[$i]);
					if ($i % 2 != 0) {
						$arrays[$i] = rtrim($arrays[$i], "\ 소리듣기");
					}
			}
			
			$arraym = explode('<li>', $mean[0]);
			array_shift($arraym);

            return ["means"=>$arraym, "example"=>$arrays];
        } else {
            return '검색 결과가 없습니다.';
        }
    }

}
