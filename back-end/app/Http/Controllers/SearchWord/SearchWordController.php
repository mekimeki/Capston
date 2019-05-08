<?php
/**
 * 클래스명:                       SearchWordController
 * @package                       App\Http\Controllers\SearchWord
 * 클래스 설명:                   단어검색
 * 만든이:                        3-WDJ 3조 メキメキ 1701281 최찬민
 * 만든날:                        2019년 4월 11일
 * 수정일:                        2019년 5월 4일
 * 함수 목록
 * searchEn(Request) : 영어검색
 * searchJp(Request) : 일본어 검색
 */
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
		
		/*태그만제거*/
		preg_match('/<span class="txt_emph1">(.*?)<\/span>/is', $result, $pronunciation);
		
		/*태그 와 태그 내용 통째로 제거*/
		preg_match('/<div class="card_word #word #eng">(.*?)<\/ul>/is', $result, $mean);
		$mean= preg_replace("!<div(.*?)<\/div>!is","",$mean);
		
		/*태그만제거*/
		if($pronunciation && $mean){
			return response()->json([
				'word'=>strip_tags($pronunciation[0]),
				'mean'=>strip_tags($mean[0]),
			]);
			return $pronunciation[0].' : '.$mean[0];
		}else{
			return '검색 결과가 없습니다.';
		}
	}

	public function searchJp(Request $request){
		$word = $request->word;
		if($word==''){
			return 'false';
		}
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
			
			return response()->json([
				'word'=>strip_tags($pronunciation[0]),
				'mean'=>strip_tags($mean[0])
			]);
			
			return $pronunciation[0].' : '.$mean[0];
		}else{
			return 'false';
			return '검색 결과가 없습니다.';
		}
		
	}
}
