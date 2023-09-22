@extends('backend.layout.master')
@section('title','Show Video')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 ">
        <div class="wrap">
            <h5 class="category">{{_('Category: ')}}{{$video->category->name}}</h5>
             <h3 class="title">{{_('Title: ')}}{{$video->title}}</h3>
             <div class="vido">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="title">{{_('Video:')}}</h3>
                        <video src="{{asset('storage/'.$video->video)}}" width="100%" class="border p-3" height="400px" controls></video>
                    </div>
                    <div class="col-md-6">
                        <h3 class="title">{{_('Video Thumbnail:')}}</h3>
                        <img src="{{asset('storage/'.$video->thumbnail)}}" width="100%" height="400px" class="border p-3" alt="{{$video->title}}">
                    </div>
                </div>
                <div class="description">
                    <h3 class="title">{{_('Video Description:')}}</h3>
                    <p>{{$video->description}}</p>
                </div>
             </div>
        </div>
    </div>
</div>
@endsection
