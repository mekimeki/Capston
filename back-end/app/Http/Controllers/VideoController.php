<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Http\Requests\StoreVideoRequest;
use App\Jobs\ConvertVideoForStreaming;

class VideoController extends Controller
{
    //
    public function index(){
        $videos = Video::orderBy('created_at', 'DESC')->get();
        return view('videos')->with('videos',$videos);
    }

    public function uploader(){
        return view('uploader');
    }

    public function store(Request $request){
        //return $request->video->getClientOriginalExtension();
        $path = str_random(16) . '.' . $request->video->getClientOriginalExtension();

        $request->video->storeAs('public', $path);
        $video = Video2::create([
            'disk'          => 'public',
            'original_name' => $request->video->getClientOriginalName(),
            'path'          => $path,
            'title'         => $request->title,
        ]);
        
        $this->dispatch(new ConvertVideoForStreaming($video));

        return redirect('/video');
        return response()->json([
            'id' => $video->id,
        ], 201);
        
    }
}
