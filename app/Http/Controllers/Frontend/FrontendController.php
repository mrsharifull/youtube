<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class FrontendController extends Controller
{
    public function index()
    {
        $s['videos'] = Video::with(['category','user'])->where('status',1)->latest()->get();
        return view('frontend.home',$s);
    }
    public function single($id){
        $s['video'] = Video::with(['category','user'])->where('id',$id)->first();
        return view('frontend.single_video_view',$s);
    }
}
