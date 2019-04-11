@extends('layouts.app')

@section('content')
	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mr-auto ml-auto mt-5">
        <h3 class="text-center">
            Upload Video
        </h3>
        <form method='POST' id='form' action="{{ route('upload') }}" enctype="multipart/form-data">
             {{ csrf_field() }}
			<div class="form-group">
                <label for="video-title">Title</label>
                <input type="text"
                       class="form-control"
                       name="title"
                       placeholder="Enter video title">
                @if($errors->has('title'))
                    <span class="text-danger">
                        {{$errors->first('title')}}
                    </span>
                @endif
            </div>
 
            <div class="form-group">
                <label for="exampleFormControlFile1">Video File</label>
                <input type="file" class="form-control-file" name="video">
                @if($errors->has('video'))
                    <span class="text-danger">
                        {{$errors->first('video')}}
                    </span>
                @endif
            </div>
 
            <div class="form-group">
                <input type="submit" class="btn btn-default" value='save'>
            </div>
        </form>
    </div>	
    
 <script>
	function save(){
		var form = $('#form');
		var data = new FormData(form[0])
		console.log(data.get('video'))
		$.ajax({ 
		     url: "{{ route('upload') }}", 
		     type: 'post', 
		     data: data, 
		     cache: false, 
		     processData: false, 
		     contentType : false, 
		     success: function (data) { 
		     	console.log(data.message)
		     }, 
		     error: function (jqXHR, textStatus, errorThrown) { 
		      console.log(jqXHR,textStatus.errorThrown); 
		      alert('error');
		     } 
	    }); 
	}
</script>
@endSection
