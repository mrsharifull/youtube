<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoCategory;
use App\Models\Video;

class VideoController extends Controller
{
    public function index(){
        $s=[];
        if(auth()->user()->role == 'user'){
            $s['videos'] = Video::where('user_id',auth()->user()->id)->latest()->get();
        }else{
            $s['videos'] = Video::latest()->get();
        }

        return view('backend.video.index',$s);
    }
    public function create(){
        $s['cats'] = VideoCategory::where('status',1)->latest()->get();
        return view('backend.video.create',$s);
    }
    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'title' => ['required', 'string', 'max:255'],
            'video' => ['required','file','mimes:mp4'],
            'thumbnail' => ['required','image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['required', 'string'],
            'cat_id' => ['required','exists:video_categories,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $video = new Video();
        if ($req->hasFile('video')) {
            $video_up = $req->file('video');
            $path = $video_up->store('videos/'.auth()->user()->id.'/video', 'public');
            $video->video = $path;
        }
        if ($req->hasFile('thumbnail')) {
            $thumbnail = $req->file('thumbnail');
            $path = $thumbnail->store('videos/'.auth()->user()->id.'/thumbnail', 'public');
            $video->thumbnail = $path;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->cat_id = $req->cat_id;
        $video->user_id = auth()->user()->id;
        $video->save();
        return redirect()->route('video.index')->withStatus(__("Video $video->title Created Successfully"));
    }
    public function edit($id){
        $s['video'] = Video::findOrFail($id);
        $s['cats'] = VideoCategory::where('status',1)->latest()->get();
        return view('backend.video.edit',$s);
    }
    public function update(Request $req , $id){

        $validator = Validator::make($req->all(), [
            'title' => ['required', 'string', 'max:255'],
            'video' => ['nullable','file','mimes:mp4'],
            'thumbnail' => ['nullable','image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['required', 'string'],
            'cat_id' => ['required','exists:video_categories,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $video = Video::findOrFail($id);
        if ($req->hasFile('video')) {
            $video_up = $req->file('video');
            $path = $video_up->store('videos/'.auth()->user()->id.'/thumbnail', 'public');
            $this->fileDelete($video->video);
            $video->video = $path;
        }
        if ($req->hasFile('thumbnail')) {
            $thumbnail = $req->file('thumbnail');
            $path = $thumbnail->store('videos/'.auth()->user()->id.'/thumbnail', 'public');
            $this->fileDelete($video->thumbnail);
            $video->thumbnail = $path;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->cat_id = $req->cat_id;
        $video->user_id = auth()->user()->id;
        $video->update();
        return redirect()->route('video.index')->withStatus(__("Category $video->title Updated Successfully"));
    }
    public function delete($id){
        $video = Video::findOrFail($id);
        $this->fileDelete($video->video);
        $this->fileDelete($video->thumbnail);
        $video->delete();
        return redirect()->route('video.index')->withStatus(__("Category $video->title Deleted Successfully"));
    }
    public function show($id)
    {
        $s['video'] = Video::with('category')->where('id',$id)->first();
        return view('backend.video.show',$s);
    }
    public function status($id){
        $video = Video::findOrFail($id);
        ($video->status == 1) ? $video->status = 0 : $video->status = 1;
        $video->update();
        return redirect()->route('video.index')->withStatus(__("Video $video->title Status Change Successfully"));
    }
}
