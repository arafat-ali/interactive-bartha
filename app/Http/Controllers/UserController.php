<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function home(){
        $posts = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->select('posts.*', 'users.id as userId', 'users.firstName', 'users.lastName', 'users.email')
                    ->orderBy('posts.id', 'DESC')
                    ->get();

        return view('user.pages.home', ["data" => $posts]);
    }


}
