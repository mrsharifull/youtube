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
    public function create(){
        return view('backend.admin.user.create');
    }
    public function store(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['nullable'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = new User();
        $user->name = $req->name;
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
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'role' => ['nullable'],
            'password' => ['nullable'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role = $req->role;
        $user->update();
        return redirect()->route('user.index')->withStatus(__($user->name.' Updated Successfully'));
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
