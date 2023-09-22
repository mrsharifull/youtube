@extends('frontend.layout.master')
@section('title','Single Video')
@section('content')
<section class="videos-section">
    <div class="container">
       <div class="main-colam">
             <div class="flex-colam1">
                  <video controls autoplay loop> <source src="{{asset('storage/'.$video->video)}}"></video>
                  <h1 style="margin-top: 15px;">{{$video->title}}</h1>
                  <div class="flex-1-sub-colam">
                      <div class="colam-1">
                       <div class="author_image"> <a href="#"><img src="{{asset('storage/'.$video->user->image)}}" alt="{{$video->user->name}}"></a></div>

                        <div class="text"> <a href="#"> {{$video->user->name}}</a> <p>150K subscrbe</p> </div>
                        <div class="buttons"> <a href="#">Subscrbe</a>  </div>
                      </div>
                      <div class="colam-2">
                             <form action="">
                                <div class="like-dislike">
                                         <div class="like"><input type="submit" value="       like"></div>
                                         <div class="dislike"><input type="submit" value="" m></div>
                                          <div class="shere"> <a href="#">Shere</a> </div>
                                          <div class="three-dot"><i class="fa-solid fa-ellipsis"></i></div>
                                </div>
                               </form>
                      </div>
                  </div>

                  <textarea placeholder="Comments" style="width: 100%; height: 60px; margin-top: 20px; resize: none; font-size: 20px;"></textarea>
             </div>
             <div class="flex-colam2">


               <div class="top-text">
                 <a href="#" class="first-text"> All</a>  <a href="#" class="seecend-text"> From  Md sujon Official </a> <a href="#" class="thard-text">4k Ragulation</a>
             </div>
                @foreach ($video->category->videos as $cat_video)
                    @if($video->id == $cat_video->id)
                        @continue
                    @endif
                    <div class="sub-flex-colam">
                        <div class="videos">
                                <video controls> <source src="{{asset('storage/'.$cat_video->video)}}"></video>
                        </div>
                        <div class="text">
                            <h2>{{$cat_video->title}}</h2>
                            <h3>{{$cat_video->user->name}}</h3>
                            <h4>10M views</h4>
                        </div>
                    </div>
                @endforeach
             </div>
       </div>

    </div>
</section>
@endsection
