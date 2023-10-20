<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Playlist;
use Illuminate\Support\Facades\Validator;

class PlaylistController extends Controller
{
    public function index(){
        if(auth()->user()->role == 'user'){
            $s['playlists'] =Playlist::where('user_id',auth()->user()->id)->latest()->get();
        }else{
            $s['playlists'] = Playlist::latest()->get();
        }
        return view('backend.video.playlist.index',$s);
    }
    public function create(){
        return view('backend.video.playlist.create');
    }
    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cat = new Playlist();
        $cat->name = $req->name;
        $cat->user_id = auth()->user()->id;
        $cat->save();
        return redirect()->route('video.playlist.index')->withStatus(__("Playlist $cat->name Created Successfully"));
    }
    public function edit($id){
        $s['cat'] = Playlist::findOrFail($id);
        return view('backend.video.playlist.edit',$s);
    }
    public function update(Request $req , $id){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cat = Playlist::findOrFail($id);
        $cat->name = $req->name;
        $cat->user_id = auth()->user()->id;
        $cat->update();
        return redirect()->route('video.playlist.index')->withStatus(__("Playlist $cat->name Updated Successfully"));
    }
    public function delete($id){
        $cat = Playlist::findOrFail($id);
        $cat->delete();
        return redirect()->route('video.playlist.index')->withStatus(__("Playlist $cat->name Deleted Successfully"));
    }
    public function show($id)
    {
        $cat = Playlist::findOrFail($id);
        return response()->json(['data'=>$cat]);
    }
    public function status($id){
        $cat = Playlist::findOrFail($id);
        ($cat->status == 1) ? $cat->status = 0 : $cat->status = 1;
        $cat->update();
        return redirect()->route('video.playlist.index')->withStatus(__("Playlist $cat->name Status Change Successfully"));
    }
}
