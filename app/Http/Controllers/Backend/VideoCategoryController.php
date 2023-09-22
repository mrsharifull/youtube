<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\VideoCategory;

class VideoCategoryController extends Controller
{
    public function index(){
        $s['cats'] = VideoCategory::all();
        return view('backend.video.category.index',$s);
    }
    public function create(){
        return view('backend.video.category.create');
    }
    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cat = new VideoCategory();
        $cat->name = $req->name;
        $cat->save();
        return redirect()->route('video.cat.index')->withStatus(__("Category $cat->name Created Successfully"));
    }
    public function edit($id){
        $s['cat'] = VideoCategory::findOrFail($id);
        return view('backend.video.category.edit',$s);
    }
    public function update(Request $req , $id){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cat = VideoCategory::findOrFail($id);
        $cat->name = $req->name;
        $cat->update();
        return redirect()->route('video.cat.index')->withStatus(__("Category $cat->name Updated Successfully"));
    }
    public function delete($id){
        $cat = VideoCategory::findOrFail($id);
        $cat->delete();
        return redirect()->route('video.cat.index')->withStatus(__("Category $cat->name Deleted Successfully"));
    }
    public function show($id)
    {
        $cat = VideoCategory::findOrFail($id);
        return response()->json(['data'=>$cat]);
    }
    public function status($id){
        $cat = VideoCategory::findOrFail($id);
        ($cat->status == 1) ? $cat->status = 0 : $cat->status = 1;
        $cat->update();
        return redirect()->route('video.cat.index')->withStatus(__("Category $cat->name Status Change Successfully"));
    }
}
