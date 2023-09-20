<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    function admin(){
        return view('backend.admin.dashboard');
    }

    // User Management
    function index(){
        $s['users'] = User::all();
        return view('backend.admin.user.index',$s);
    }
    function create(){
        return view('backend.admin.user.create');
    }
    function store(Request $req){

        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['nullable'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // User::create([
        //     'name' => $req->input('name'),
        //     'email' => $req->input('email'),
        //     'password' => Hash::make($req->input('password')),
        //     'role' => $req->input('role'),
        // ]);
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->role = $req->role;
        $user->save();

        return redirect()->route('user.index')->withStatus(__($user->name.' Created Successfully'));
    }

}
