<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function home(){
        return view('user.pages.home');
    }

    public function profile(){
        return view('user.pages.profile');
    }

    public function editProfile(){
        return view('user.pages.editProfile');
    }
}
