<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Playlist;
use App\Models\VideoCategory;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use App\Jobs\UploadVideoToSFTP;
use App\Jobs\UploadThumbnailToSFTP;

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
        $s['playlists'] = Playlist::where('status',1)->latest()->get();
        $s['cats'] = VideoCategory::where('status',1)->latest()->get();
        return view('backend.video.create',$s);
    }
    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'title' => ['required', 'string', 'max:255'],
            'video' => ['required','file','mimes:mp4'],
            'thumbnail' => ['required','image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['required', 'string'],
            'playlist_id' => ['required','exists:playlists,id'],
            'cat_id' => ['required','exists:video_categories,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $video = new Video();
        if ($req->hasFile('video')) {
            $video_up = $req->file('video');
            $fileName = 'video_' . uniqid(3) . '.' . $video_up->getClientOriginalExtension();
            $temporaryFilePath = $video_up->storeAs('video',$fileName,'public'); // Store in the 'public' disk
            UploadVideoToSFTP::dispatch($fileName, $temporaryFilePath);
            $video->video = 'video/'.$fileName;
        }
        // if ($req->hasFile('video')) {
        //     $video_up = $req->file('video');
        //     $fileName = 'video_' . uniqid(3) . '.' . $video_up->getClientOriginalExtension();
        //     $filePath = $video_up->store('youtube'); // Store the file in a temporary location
        // }
        // if ($req->hasFile('thumbnail')) {
        //     $thumbnail = $req->file('thumbnail');
        //     $fileName = 'thumbnail_' . uniqid(3) . '.' . $thumbnail->getClientOriginalExtension();
        //     $filePath = $thumbnail->store('youtube'); // Store the file in a temporary location
        // }
        // if ($req->hasFile('video')) {
        //     try {
        //         $video_up = $req->file('video');
        //         $videoFileName = 'video_'.uniqid(3) . '.' . $video_up->getClientOriginalExtension();
        //         $video = Storage::disk('sftp')->put($videoFileName, file_get_contents($video_up));

        //         if ($video) {
        //             // File upload successful
        //             $videoPath = $videoFileName;
        //             // Do whatever you need with $videoPath
        //         } else {
        //             // File upload failed
        //             dd("File upload failed");
        //         }
        //     } catch (\Exception $e) {
        //         // Handle the exception here, e.g., log the error message
        //         dd($e->getMessage());
        //     }
        // }
        if ($req->hasFile('thumbnail')) {
            $thumbnail = $req->file('thumbnail');
            $fileName = 'thumbnail_'.uniqid(3). '.' . $thumbnail->getClientOriginalExtension();
            $temporaryFilePath = $thumbnail->storeAs('thumbnail',$fileName,'public');
            UploadThumbnailToSFTP::dispatch($fileName,$temporaryFilePath);
            $video->thumbnail = 'thumbnail/'.$fileName;
            // // Storage::disk('remote-sftp')->put($thumbnailFileName, file_get_contents($thumbnail), 'public');
            // $filesystem = Storage::disk('remote-sftp');
            // $filesystem->put('thumbnail/'.$thumbnailFileName, file_get_contents($thumbnail));
            // $thumbnailPath = 'thumbnail/'.$thumbnailFileName;

        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->playlist_id = $req->playlist_id;
        $video->cat_id = $req->cat_id;
        $video->user_id = auth()->user()->id;
        $video->save();
        return redirect()->route('video.index')->withStatus(__("Video $video->title Created Successfully"));
    }
    public function edit($id){
        $s['video'] = Video::findOrFail($id);
        $s['playlists'] = Playlist::where('status',1)->latest()->get();
        $s['cats'] = VideoCategory::where('status',1)->latest()->get();
        return view('backend.video.edit',$s);
    }
    public function update(Request $req , $id){

        $validator = Validator::make($req->all(), [
            'title' => ['required', 'string', 'max:255'],
            'video' => ['nullable','file','mimes:mp4'],
            'thumbnail' => ['nullable','image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['required', 'string'],
            'playlist_id' => ['required','exists:playlists,id'],
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
        $video->playlist_id = $req->playlist_id;
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
