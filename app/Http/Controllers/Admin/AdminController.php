<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function admin(){
        return view('backend.admin.dashboard');
    }

    // User Management
    function create(){
        return view('backend.admin.user.create');
    }
}
