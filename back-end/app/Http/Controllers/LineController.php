<?php

namespace App\Http\Controllers;

use App\LBook;
use App\Line;
use Illuminate\Http\Request;
use App\Http\Controllers\Snoopy;
use Illuminate\Support\Arr;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($l_id = null) // 대사 보여주기
    {
        $books = lbook::where('m_id', 1)->select('lbook_pk')->get();
        \Log::debug($books);
        $lines = [];
        if($l_id == false) {
            for($i=0; $i<$books->count(); $i++) {
                $array[$i] = json_decode(line::where('lbook_pk', $books[$i]->lbook_pk)->select('line', 'pic_add AS picture')->get(), true);
                $lines = array_merge($lines, $array[$i]);
            }
        } else {
            $lines = line::where('lbook_pk', $l_id)->select('line', 'pic_add_st AS picture')->get();
        }
        $lines = json_encode($lines, JSON_UNESCAPED_UNICODE);
        return $lines;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) // 대사장 만들기
    {
        $id = $request->input('line_id');
        $title = $request->input('title');
        $lang = $request->input('lang');
        $lines = $request->input('lines');
        
        \Log::debug($title);
        \Log::debug($words);
        \Log::debug(gettype($words));
        
        if($lang == '일본어'){
            $lang = 'JP';
        }else if($lang == '한국어'){
            $lang = 'KR';
        }else if($lang == '영어'){
            $lang = 'EN';
        }else if($lang == '중국어'){
            $lang = 'CN';
        }else {
            $lang = 'ND';
        }

        if (!$id) {
            \DB::insert('insert into lbook_tb (m_id, lbook_tt, lbook_lan) values (?, ?, ?)', [1, $title, $lang]);
            $id = \DB::getPdo()->lastInsertId();
        }

        // if($lines){
        //     $line = explode(',', $lines);
        //     for ($i=0; $i<count($line); $i++) {
        //         \DB::insert('insert into line_tb (lbook_pk, line, explain, pic_add, v_id, start_dt) values(?, ?, ?, ?, ?)', [$id, $word[$i], "N", 0, "F"]);
        //     }
        // }

        // insert orm
        return "ok";
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
    public function show() // 대사장 목록 보여주기
    {
        $books = lbook::where('m_id', 1)->select('lbook_tt AS title')->get();
        $books = json_encode($books, JSON_UNESCAPED_UNICODE);
        return $books;
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
    public function destroy() // 대사 삭제
    {
        $id = 1;
        $lines = line::where('lbook_pk', $id)->select('line_pk AS id')->get();
        
        for($i=0; $i<$lines->count(); $i++) {
            line::where('line_pk', $lines[$i]->id)->delete();
        }
    }
}
