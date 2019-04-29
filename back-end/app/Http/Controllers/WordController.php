<?php

namespace App\Http\Controllers;

use App\WBook;
use App\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Snoopy;
use Illuminate\Support\Arr;

class WordController extends Controller
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

    public function index() // 자세히 보기
    {
        $word = "random";
        $this->snoopy->fetch('https://m.dic.daum.net/search.do?q='.$word);
        $result = $this->snoopy->results;
        $matchFlag = preg_match('/<ul class="list_search">(.*?)<\/ul>/is', $result, $mean);
        /*태그만제거*/
        $mean = preg_replace("/<ul[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/ul>/i", '', $mean);
        $mean = preg_replace("/<\/li>/", '', $mean);
        $mean = preg_replace("/<span[^>]*>/i", '', $mean);
        $mean = preg_replace("/<\/span>/", '', $mean);
        // $mean = preg_replace("/(<daum[^>]*>)/i", '', $mean);
        $mean = preg_replace("/(<\/daum:word>)/", '', $mean);
        $mean = preg_replace("/\t|\n/", '', $mean);
        // \Log::debug($result);
        $mean = json_encode($mean, JSON_UNESCAPED_UNICODE);
        return $mean;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() // 단어장 목록 보여주기
    {
        $books = wbook::where('m_id', 1)->select('wbook_tt AS title')->get();
        $books = json_encode($books, JSON_UNESCAPED_UNICODE);
        return $books;
    }

    public function book($b_id = null)
    {
        $books = wbook::where('m_id', 1)->select('wbook_pk')->get();
        $vocas = [];
        if($b_id == false) {
            for($i=0; $i<$books->count(); $i++) {
                $array[$i] = json_decode(word::where('wbook_pk', $books[$i]->wbook_pk)->select('w_pk AS id', 'w_nm AS word', 'memo_st AS memorized')->get(), true);
                $vocas = array_merge($vocas, $array[$i]);
            }
        } else {
            $vocas = word::where('wbook_pk', $b_id)->select('w_pk AS id', 'w_nm AS word', 'memo_st AS memorized')->get();
        }
        $vocas = json_encode($vocas, JSON_UNESCAPED_UNICODE);
        return $vocas;
    }

    public function memo($mm = null)
    {
        //classifyWord 

        $books = wbook::where('m_id', 1)->select('wbook_pk')->get();

        if($mm == "T") {
            for($i=0; $i<$books->count(); $i++) {
                $vocas = word::where('memo_st', $mm)->select('w_pk AS id', 'w_nm AS word', 'memo_st AS memorized')->get();
            }
        } else {
            $vocas = word::where('memo_st', $mm)->select('w_pk AS id', 'w_nm AS word', 'memo_st AS memorized')->get();
        }
        $vocas = json_encode($vocas, JSON_UNESCAPED_UNICODE);
        return $vocas;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) // 단어장 제목 수정
    {
        $title = $request->input('title');

        $wbook = wbook::find('wbook_tt');
        // 그 멤버의 단어장 목록을 출력하고
        // 단어장의 제목을 수정 (멤버 아이디, 단어장의 아이디)

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   
        $memo_id = $request->input('id');
        $memo_flag = $request->input('flag');
        //\Log::debug($memo);

        if (word::where('w_pk', $memo_id)->update(['memo_st' => $memo_flag])) {
            return "ok";
        }
        return "nope";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $words = $request->input('selected');
        $vocas = explode(',', $words);

        for($i=0; $i<count($vocas); $i++) {
            word::where('w_pk', $vocas[$i])->delete();
        }

        return $this->book(0);
    }
}
