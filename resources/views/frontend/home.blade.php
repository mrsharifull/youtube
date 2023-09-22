@extends('frontend.layout.master')
@section('title','Home')
@section('content')
    <div class="container">

        <div class="container-main">
            @include('frontend.includes.aside')


        <div class="show">
            @include('frontend.includes.header_bottom')
            <div class="flex-column-2">
                @foreach ($videos as $video)
                    <div class="flex-column-2-content-1">
                        <a href="{{route('home.single',$video->id)}}" class="thumbnail">
                            <img src="{{asset('storage/'.$video->thumbnail)}}" alt="{{$video->title}}" height="200px" width="100%" >
                        </a>

                        <div class="video-content-1">
                            <div class="content_wrap">
                                <img class="author_image" src="{{asset('storage/'.$video->user->image)}}" alt="{{$video->user->name}}">
                                <div class="content-area">
                                    <p class="content-1">{{Str::limit($video->title, 70, '...')}}</p>
                                    <p class="content-2">{{$video->user->name}}</p>
                                    <p class="content-3">32k view . <span>2 years ago</span></p>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
            </div>
        </div>
    </div>
@endsection
