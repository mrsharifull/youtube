<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function admin(){
        return view('backend.admin.dashboard');
    }

    // User Management
    public function index(){
        $s['users'] = User::all();
        return view('backend.admin.user.index',$s);
    }
    public function profile($id){
        $s['data'] = User::with(['videos','videoCats','playlists'])->where('id',$id)->first();
        return view('backend.admin.user.profile',$s);
    }
    public function create(){
        return view('backend.admin.user.create');
    }
    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required','image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['nullable'],
            'channel_name' => ['nullable','string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = new User();
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $path = $image->store('users/'.auth()->user()->id.'/image', 'public');
            $user->image = $path;
        }
        $user->name = $req->name;
        $user->channel_name = $req->channel_name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role = $req->role;
        $user->save();
        return redirect()->route('user.index')->withStatus(__($user->name.' Created Successfully'));
    }
    public function edit($id){
        $s['user'] = User::findOrFail($id);
        return view('backend.admin.user.edit',$s);
    }
    public function update(Request $req , $id){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'image' => ['nullable','image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'role' => ['nullable'],
            'password' => ['nullable'],
            'channel_name' => ['required','string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $path = $image->store('users/'.auth()->user()->id.'/image', 'public');
            $this->fileDelete($user->image);
            $user->image = $path;
        }
        $user->name = $req->name;
        $user->channel_name = $req->channel_name;
        $user->email = $req->email;
        if(!empty($req->password)){
            $user->password = Hash::make($req->password);
        }
        $user->role = $req->role;
        $user->update();
        return redirect()->back()->withStatus(__($user->name.' Updated Successfully'));
    }
    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->withStatus(__($user->name.' Deleted Successfully'));
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user'=>$user]);
    }


}
