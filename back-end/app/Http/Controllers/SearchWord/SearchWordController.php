<?php

namespace App\Http\Controllers\SearchWord;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\SearchWord\Snoopy;

class SearchWordController extends Controller
{
    //
    public $snoopy;
    public function __construct(){
    	$this->snoopy = new Snoopy;
    }

	public function searchEn(Request $request){
		$word = $request->word;
		$this->snoopy->fetch('https://alldic.daum.net/search.do?q='.$word);////https://alldic.daum.net/search.do?q=text&dic=eng
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
		if($pronunciation && $mean){
			return $pronunciation[0].' : '.$mean[0];
		}else{
			return '검색 결과가 없습니다.';
		}
	}

	public function searchJp(Request $request){
		$word = $request->word;
		$this->snoopy->fetch('https://alldic.daum.net/search.do?q='.$word);////https://alldic.daum.net/search.do?q=text&dic=eng
		$result = $this->snoopy->results;
		
		preg_match('/<div class="card_word #word #jp">(.*?)<\/ul>/is', $result, $pronunciation);//<\/ul>//<span class="desc_listen">//<\/strong>
		
		/*특정 텍스트 제거*/
		$pronunciation = str_replace('일본어사전','',$pronunciation);
		$pronunciation = str_replace('주요 검색어','',$pronunciation);

		/*태그 와 태그 내용 통째ㅐ로 제거*/
		$pronunciation= preg_replace("!<ul(.*?)<\/ul>!is","",$pronunciation);
		$pronunciation= preg_replace("!<span class=\"desc_listen\"(.*?)<\/span>!is","",$pronunciation);
		$pronunciation= preg_replace("!<span class=\"img_comm\"(.*?)<\/span>!is","",$pronunciation);

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
		$mean = str_replace('일본어사전','',$mean);
		$mean = str_replace('주요 검색어','',$mean);

		/*태그 와 태그 내용 통째ㅐ로 제거*/
		$mean= preg_replace("!<a(.*?)<\/a>!is","",$mean);

		/*태그만제거*/
		$mean = preg_replace("/<div[^>]*>/i", '', $mean);
		$mean = preg_replace("/<ul[^>]*>/i", '', $mean);
		$mean = preg_replace("/<li[^>]*>/i", '', $mean);
		$mean = preg_replace("/<span[^>]*>/i", '', $mean);
		$mean = preg_replace("/<daum:word[^>]*>/i", '', $mean);
		$mean = preg_replace("/<h4[^>]*>/i", '', $mean);
		$mean = preg_replace("/<strong[^>]*>/i", '', $mean);
		$mean = preg_replace('/\s+/', '', $mean);
		
		if($pronunciation && $mean){
			return $pronunciation[0].' : '.$mean[0];
		}else{
			return '검색 결과가 없습니다.';
		}
		
	}
}
