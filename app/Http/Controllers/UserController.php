<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function home(){
        return view('user.pages.home');
    }

    public function profile(){
        $user = Auth::user();
        return view('user.pages.profile', ["data"=>$user]);
    }

    public function editProfile(){
        $user = Auth::user();
        return view('user.pages.editProfile', ["data"=>$user]);
    }
}
