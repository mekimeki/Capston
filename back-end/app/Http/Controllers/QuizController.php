<?php

namespace App\Http\Controllers;

use App\Voca;
use Illuminate\Http\Request;
use App\Http\Controllers\Snoopy;
use Illuminate\Support\Arr;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $snoopy;
    public function __construct(){
    	$this->snoopy = new Snoopy;
    }

    public function english()
    {
        $id = 1;
        $vocas = voca::where('b_id', $id)->select('word')->inRandomOrder()->take(4)->get();
        $random = random_int(0, $vocas->count()-1);
        $quiz = $vocas->slice($random, 1);
        $this->snoopy->fetch('https://m.dic.daum.net/search.do?q='.$quiz[$random]->word);
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

        if($matchFlag){
            $array = explode('<li>', $mean[0]);
            array_shift($array);
            
            $back = ["ques"=>$array, "choice"=>$vocas, "ans"=>$random];
            $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            return $back;
		}else{
            return '검색 결과가 없습니다.';
		}

    }

    public function japanese() 
    {
        $id = 2;
        $vocas = voca::where('b_id', $id)->select('word')->inRandomOrder()->take(4)->get();
        $random = random_int(0, $vocas->count()-1);
        $quiz = $vocas->slice($random, 1);
        $this->snoopy->fetch('https://alldic.daum.net/search.do?q='.$quiz[$random]->word.'&dic=jp');
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

		if($matchFlag){
			$array = explode('<li>', $mean[0]);
            array_shift($array);
            
            $back = ["ques"=>$array, "choice"=>$vocas, "ans"=>$random];
            $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            return $back;
		}else{
			return '검색 결과가 없습니다.';
		}
        
    }

    public function crawling() 
    {
        $id = 2;

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

        if($matchFlag){
            $array = explode('<li>', $mean[0]);
            array_shift($array);
            
            $back = ["ques"=>$array, "choice"=>$vocas, "ans"=>$random];
            $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            return $back;
		}else{
            return '검색 결과가 없습니다.';
		}
    }

    public function result(Request $request)
    {
        $results = $request->input('results');
        \Log::debug($results);
        // $result = explode(',', $results);
        // \Log::debug($result);
        \DB::insert('insert into scores (m_id, score) values (?, ?)', [1, $results]);

        return "a";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($b_id)
    {
        //$id = 2; 
        $vocas = voca::where('b_id', $b_id)->select('word')->get();
        
        $this->snoopy->fetch('https://alldic.daum.net/search.do?q='.$vocas[1]->word.'&dic=jp');
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

		if($matchFlag){
			$array = explode('<li>', $mean[0]);
            array_shift($array);
            
            // $back = ["word"=>$vocas, "mean"=>$array];
            // $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            // return $back;
            $array = json_encode($array, JSON_UNESCAPED_UNICODE);
            $vocas = json_encode($vocas, JSON_UNESCAPED_UNICODE);
            $back = ["word"=>$vocas, "mean"=>$array];
            $back = json_encode($back, JSON_UNESCAPED_UNICODE);
            return $vocas;

		}else{
			return '검색 결과가 없습니다.';
		}
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
