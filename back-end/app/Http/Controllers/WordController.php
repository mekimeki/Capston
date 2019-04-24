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
    public function index()
    {
        //
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
        $books = wbook::where('m_id', 1)->select('wbook_pk')->get();
        if($mm == "T") {
            for($i=0; $i<$books->count(); $i++) {
                $vocas = word::where('memo_st', $mm)->select('w_pk AS id', 'w_nm AS word')->get();
            }
        } else {
            $vocas = word::where('memo_st', $mm)->select('w_pk AS id', 'w_nm AS word')->get();
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
    public function update($w_id)
    {   
        $mm = word::where('w_pk', $w_id)->select('memo_st')->get();
        if ($mm[0]->memo_st == "F") {
            word::where('w_pk', $w_id)->update(['memo_st' => "T"]);
        } else {
            word::where('w_pk', $w_id)->update(['memo_st' => "F"]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //word::where('w_pk', $id)->delete();
        //$words[] = $request->input('words'); //Reqeust $request
        $b_id = 2;
        $words = word::where('wbook_pk', $b_id)->select('w_pk AS id')->get();
        
        for($i=0; $i<$words->count(); $i++) {
            word::where('w_pk', $words[$i]->id)->delete();
        }
        
    }
}
