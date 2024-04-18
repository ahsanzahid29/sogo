<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('users.user-list');
    }

    public function add(){
        return view('users.user-add');
    }

    public function save(Request $request){
        return redirect('/users-list');

    }

    public function editProfile(){
        return view('profile.edit-profile');
    }

    public function updateProfile(Request $request){
        return redirect('/dashboard');
    }
}
