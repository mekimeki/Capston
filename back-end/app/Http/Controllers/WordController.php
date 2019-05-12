<?php

namespace App\Http\Controllers;

use App\Model\WBook;
use App\Model\Word;
use App\Model\Member;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) // 단어장 추가

    {

        $id = $request->input('book_id');
        $title = $request->input('title');
        $lang = $request->input('lang');
        $words = $request->input('words');

        \Log::debug($title);
        \Log::debug($words);
        \Log::debug(gettype($words));

        if ($lang == '일본어') {
            $lang = 'JP';
        } else if ($lang == '한국어') {
            $lang = 'KR';
        } else if ($lang == '영어') {
            $lang = 'EN';
        } else if ($lang == '중국어') {
            $lang = 'CN';
        } else {
            $lang = 'ND';
        }

        if (!$id) {
            \DB::insert('insert into wbook_tb (m_id, wbook_tt, wbook_lan) values (?, ?, ?)', [1, $title, $lang]);
            $id = \DB::getPdo()->lastInsertId();
        }

        if ($words) {
            $word = explode(',', $words);
            for ($i = 0; $i < count($word); $i++) {
                \DB::insert('insert into word_tb (wbook_pk, w_nm, morp, w_cnt, memo_st) values(?, ?, ?, ?, ?)', [$id, $word[$i], "N", 0, "F"]);
            }
        }


        // insert orm
        return $id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) // 북마크한 단어 저장
    {
        $email = $request->input('email');
        \Log::debug($email);
        $w_nm = $request->input('word');

        $id = member::where('email',$email)->select('member_pk')->get()->toArray();

        $books = wbook::where('m_id', $id[0]['member_pk'])->select('wbook_pk')->first()->get()->toArray();

        $inCheck = word::select('w_pk', 'w_nm', 'w_cnt')->where('wbook_pk', $books[0]['wbook_pk'])->where('w_nm',$w_nm)->get()->toArray();

        \Log::debug(count($inCheck));

        if(count($inCheck) >= 1){
            word::where('w_pk', $inCheck[0]["w_pk"])
            ->update(['w_cnt' => $inCheck[0]['w_cnt'] + 1]);
        }else{
            word::insert(['wbook_pk'=>$books[0]['wbook_pk'], 'w_nm'=>$w_nm, 'morp'=>'N']);
        }

        return "success";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() // 단어장 목록 보여주기

    {
        $books = wbook::where('m_id', 1)->select('wbook_pk AS id', 'wbook_tt AS title')->get();
        $books = json_encode($books, JSON_UNESCAPED_UNICODE);
        return $books;
        //아이디랑 제목 같이 넘김
    }

    public function book($b_id = null)
    {
        $books = wbook::where('m_id', 1)->select('wbook_pk')->get()->toArray();
        $vocas = [];

        if ($b_id == false) {
            $vocas = word::select('w_nm as word', 'w_pk as id', 'memo_st as memorized')
                ->whereIn('wbook_pk',$books)
                ->groupBy('w_nm')
                ->get()->toArray();

        } else {
            $vocas = word::select('w_nm as word', 'w_pk as id', 'memo_st as memorized')
                ->where('wbook_pk',$b_id)
                ->groupBy('w_nm')
                ->get()->toArray();
        }

        $vocas = json_encode($vocas, JSON_UNESCAPED_UNICODE);
        return $vocas;
    }

    public function memo($mm = null)
    {
        //classifyWord

        $books = wbook::where('m_id', 1)->select('wbook_pk')->get();

            $vocas = \DB::table('word_tb')
                ->select('w_nm as word', 'w_pk as id', 'memo_st as memorized')
                ->whereIn('wbook_pk',$books)
                ->where('memo_st', $mm)
                ->groupBy('w_nm')
                ->get()->toArray();
                

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
        $title = $request->input('title'); // 타이틀이랑 id 두개 받아내기
        $id = $request->input('id');

        if (wbook::where('wbook_pk', $id)->update(['wbook_tt' => $title])) {
            return "ok";
        }
        return "nope";
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
    public function update(Request $request) // 암기 미암기

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
    public function destroy(Request $request) // 단어 삭제
    {
        $words = $request->input('selected');
        $vocas = explode(',', $words);

        for ($i = 0; $i < count($vocas); $i++) {
            word::where('w_pk', $vocas[$i])->delete();
        }

        return $this->book(0);
    }

    public function delete(Reqeust $request) // 단어장 삭제

    {
        $id = $request->input('id');

        if (wbook::where('wbook_pk', $id)->delete()) {
            return "ok";
        }
        return "nope";
    }

}