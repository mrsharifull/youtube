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

class VideoController extends Controller
{

    public function index()
    {
        $s = [];
        if (auth()->user()->role == 'user') {
            $s['videos'] = Video::where('user_id', auth()->user()->id)->latest()->get();
        } else {
            $s['videos'] = Video::latest()->get();
        }

        return view('backend.video.index', $s);
    }
    public function create()
    {
        $s['playlists'] = Playlist::where('status', 1)->latest()->get();
        $s['cats'] = VideoCategory::where('status', 1)->latest()->get();
        return view('backend.video.create', $s);
    }
    public function store(Request $req)
    {

        $validator = Validator::make($req->all(), [
            'title' => ['required', 'string', 'max:255'],
            'video' => ['required', 'file', 'mimes:mp4,wmv'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['required', 'string'],
            'playlist_id' => ['required', 'exists:playlists,id'],
            'cat_id' => ['required', 'exists:video_categories,id'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if (empty(auth()->user()->channel_name)) {
            return redirect()->route('user.edit', auth()->user()->id)->withStatus(__("Please create channel name before uploading video"));
        }
        $video = new Video();
        if ($req->hasFile('video')) {
            $file = $req->file('video');
            $filenamewithextension = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenametostore = 'video_' . uniqid() . '.' . $extension;
            $directory = 'video';
            Storage::disk('remote-sftp')->makeDirectory($directory, 0755, true);
            Storage::disk('remote-sftp')->put($directory . '/' . $filenametostore, fopen($file, 'r+'));
            $video->video = $directory . '/' . $filenametostore;
        }
        if ($req->hasFile('thumbnail')) {
            $thumbnail = $req->file('thumbnail');
            $filenamewithextension = $thumbnail->getClientOriginalName();
            $extension = $thumbnail->getClientOriginalExtension();
            $filenametostore = 'thumbnail_' . uniqid() . '.' . $extension;
            $directory = 'image';
            Storage::disk('remote-sftp')->makeDirectory($directory, 0755, true);
            Storage::disk('remote-sftp')->put($directory . '/' . $filenametostore, fopen($thumbnail, 'r+'));
            $video->thumbnail = $directory . '/' . $filenametostore;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->playlist_id = $req->playlist_id;
        $video->cat_id = $req->cat_id;
        $video->user_id = auth()->user()->id;
        $video->save();
        return redirect()->route('video.index')->withStatus(__("Video $video->title Created Successfully"));
    }
    public function edit($id)
    {
        $s['video'] = Video::findOrFail($id);
        $s['playlists'] = Playlist::where('status', 1)->latest()->get();
        $s['cats'] = VideoCategory::where('status', 1)->latest()->get();
        return view('backend.video.edit', $s);
    }
    public function update(Request $req, $id)
    {

        $validator = Validator::make($req->all(), [
            'title' => ['required', 'string', 'max:255'],
            'video' => ['nullable', 'file', 'mimes:mp4'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'description' => ['required', 'string'],
            'playlist_id' => ['required', 'exists:playlists,id'],
            'cat_id' => ['required', 'exists:video_categories,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $video = Video::findOrFail($id);
        if ($req->hasFile('video')) {
            $file = $req->file('video');
            $filenamewithextension = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filenametostore = 'video_' . uniqid(3) . '.' . $extension;
            $directory = 'video';
            Storage::disk('remote-sftp')->makeDirectory($directory, 0755, true);
            Storage::disk('remote-sftp')->put($directory . '/' . $filenametostore, fopen($file, 'r+'));
            Storage::disk('remote-sftp')->delete($video->video);
            $video->video = $directory . '/' . $filenametostore;
        }
        if ($req->hasFile('thumbnail')) {
            $thumbnail = $req->file('thumbnail');
            $filenamewithextension = $thumbnail->getClientOriginalName();
            $extension = $thumbnail->getClientOriginalExtension();
            $filenametostore = 'thumbnail_' . uniqid(3) . '.' . $extension;
            $directory = 'image';
            Storage::disk('remote-sftp')->makeDirectory($directory, 0755, true);
            Storage::disk('remote-sftp')->put($directory . '/' . $filenametostore, fopen($thumbnail, 'r+'));
            Storage::disk('remote-sftp')->delete($video->thumbnail);
            $video->thumbnail = $directory . '/' . $filenametostore;
        }
        $video->title = $req->title;
        $video->description = $req->description;
        $video->playlist_id = $req->playlist_id;
        $video->cat_id = $req->cat_id;
        $video->user_id = auth()->user()->id;
        $video->update();
        return redirect()->route('video.index')->withStatus(__("Category $video->title Updated Successfully"));
    }
    public function delete($id)
    {
        $video = Video::findOrFail($id);
        Storage::disk('remote-sftp')->delete($video->video);
        Storage::disk('remote-sftp')->delete($video->thumbnail);
        $video->delete();
        return redirect()->route('video.index')->withStatus(__("Category $video->title Deleted Successfully"));
    }
    public function show($id)
    {
        $s['video'] = Video::with('category')->where('id', $id)->first();
        return view('backend.video.show', $s);
    }
    public function status($id)
    {
        $video = Video::findOrFail($id);
        ($video->status == 1) ? $video->status = 0 : $video->status = 1;
        $video->update();
        return redirect()->route('video.index')->withStatus(__("Video $video->title Status Change Successfully"));
    }
}
