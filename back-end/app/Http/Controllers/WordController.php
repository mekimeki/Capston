<?php

namespace App\Http\Controllers;

use App\Book;
use App\Voca;
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
        $books = book::where('m_id', 1)->select('title')->get();
        $books = json_encode($books, JSON_UNESCAPED_UNICODE);
        return $books;
    }

    public function book($b_id = null)
    {
        $books = book::where('m_id', 1)->select('b_id')->get();
        $vocas = [];
        if($b_id == false) {
            for($i=0; $i<$books->count(); $i++) {
                $array[$i] = json_decode(voca::where('b_id', $books[$i]->b_id)->select('word', 'memorized')->get(), true);
                $vocas = array_merge($vocas, $array[$i]);
            }
        } else {
            $vocas = voca::where('b_id', $b_id)->select('word', 'memorized')->get();
        }
        $vocas = json_encode($vocas, JSON_UNESCAPED_UNICODE);
        return $vocas;
    }

    public function memo($mm = null)
    {
        $books = book::where('m_id', 1)->select('b_id')->get();
        if($mm == "T") {
            for($i=0; $i<$books->count(); $i++) {
                $vocas = voca::where('memorized', $mm)->select('word')->get();
            }
        } else {
            $vocas = voca::where('memorized', $mm)->select('word')->get();
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
        $mm = voca::where('w_id', $w_id)->select('memorized')->get();
        if ($mm[0]->memorized == "F") {
            voca::where('w_id', $w_id)->update(['memorized' => "T"]);
        } else {
            voca::where('w_id', $w_id)->update(['memorized' => "F"]);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reqeust $reqeust)
    {
        $deletes = $reqeust->input('deletedWord');
        voca::where('w_id', $deletes)->delete();
    }
}
