<?php

namespace App\Http\Controllers;

use App\Model\LBook;
use App\Model\Line;
use Illuminate\Http\Request;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($l_id = null) // 대사 보여주기

    {
        $books = lbook::where('m_id', 1)->select('lbook_pk')->get()->toArray();
        $lines = [];

        if ($l_id == false) {
            $lines = \DB::table('line_tb')
                ->select('line_pk as id', 'line', 'explain', 'pic_add', 'v_id', 'start_dt')
                ->whereIn('lbook_pk', $books)
                ->groupBy('line')
                ->get()->toArray();
        } else {
            $lines = \DB::table('line_tb')
                ->select('line_pk as id', 'line', 'explain', 'pic_add', 'v_id', 'start_dt')
                ->where('lbook_pk', $l_id)
                ->groupBy('line')
                ->get()->toArray();
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
        
        $all = $request->all();
        $id = $request->input('book_id');
        $title = $request->input('title');
        $lang = $request->input('lang');
        $lines = $request->input('lines');
        $explains = $request->input('explains');
        $start_dts = $request->input('start_dts');
        $v_ids = $request->input('v_ids');
        $pic_adds = $request->input('pic_adds');

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
            \DB::insert('insert into lbook_tb (m_id, lbook_tt, lbook_lan) values (?, ?, ?)', [1, $title, $lang]);
            $id = \DB::getPdo()->lastInsertId();
        }

        if ($lines) {

            for ($i = 0; $i < count($lines); $i++) {
                line::insert([
                    'lbook_pk' => $id,
                    'line' => $lines[$i],
                    'explain' => $explains[$i],
                    'pic_add' => $pic_adds[$i],
                    'v_id' => $v_ids[$i],
                    'start_dt' => $start_dts[$i]]);
            }
        }

        return $id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request) // 대사 저장

    {

        // \Log::debug($_SERVER['SERVER_ADDR']);
        $ip = $_SERVER['SERVER_ADDR'];
        // ($picture, $id)
        $all = $request->all();

        // \Log::debug($all);

        $picture = $request->input('picture');
        $line = $request->input("explain");
        $start = $request->input("title");
        $v_id = $request->input("video_pk");
        $id = 2;

        $pictures = explode(',', $picture);

        // \Log::debug($pictures);

        if (isset($pictures[1])) {
            $path = public_path("picture/" . $id);

            if (!is_dir($path)) {
                mkdir($path);
            }

            // \Log::debug($pictures[0]);

            $date = date("Y-m-d_H-i-s");
            $name = $date . "_picture.png";

            $data = base64_decode($pictures[1]);
            $path = $id . '/' . $name;

            \Storage::disk('local_pic')->put($path, $data);
            // $url = \Storage::disk('local_pic')->url($path);
            $url = 'http://' . $ip . '/picture/' . $id . '/' . $name;

            \DB::table('line_tb')->insert([
                'lbook_pk' => $id, 'line' => $line, 'explain' => '설명', 'pic_add' => $url, 'v_id' => $v_id, 'start_dt' => $start,
            ]);

            return "ok";

        } else {

        }
        // return "ok";

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show() // 대사장 목록 보여주기

    {
        $books = lbook::where('m_id', 1)->select('lbook_pk as id', 'lbook_tt AS title')->get();
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
    public function destroy(Request $request) // 대사 삭제

    {
        $line = $request->input('selected');
        $lines = explode(',', $line);

        for ($i = 0; $i < count($lines); $i++) {
            line::where('line_pk', $lines[$i])->delete();
        }

        return $this->index(0);
    }

    public function delete(Reqeust $request) // 대사집 삭제

    {
        $id = $request->input('id');

        if (lbook::where('lbook_pk', $id)->delete()) {
            return "ok";
        }
        return "nope";
    }
}
