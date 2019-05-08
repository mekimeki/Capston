@extends('layouts.app')
 
@section('content')
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mr-auto ml-auto mt-5">
        <h3 class="text-center">
            Videos
        </h3>

        <video id="my_video_2" class="video-js vjs-default-skin" controls preload="auto" width="640" height="360" data-setup='{}'>
            <source src="{{asset('storage/168.m3u8')}}" type="application/x-mpegURL">
        </video>

    </div>
    <video src='http://localhost/api/video/streaming/185' controls preload="auto" width="640" height="360"></video>
    <video src="{{asset('storage/185.mp4')}}" controls preload="auto" width="640" height="360"></video>

    <video width="320" height="240" controls="controls"  src="https://media.w3.org/2010/05/sintel/trailer.mp4">
    
	</video>
@endSection