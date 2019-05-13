<?php

namespace App\Http\Controllers;

use App\Model\WBook;
use App\Model\Word;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // 공개 단어장 목록
    {
        $list = wbook::where('wbook_public', 'T')->select('m_id as member', 'wbook_pk as id', 'wbook_tt as title')->get();
        $list = json_encode($list, JSON_UNESCAPED_UNICODE);
        return $list;
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
    public function show($id) // 앨범집 선택했을 때 앨범 안 단어 보여주기
    {
        //$id = $request->input('id');
        $title = wbook::where('wbook_pk', $id)->select('wbook_tt as title')->get();
        $vocas = word::where('wbook_pk', $id)->select('w_pk as id', 'w_nm as word')->get();

        $title = json_encode($title, JSON_UNESCAPED_UNICODE);
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
