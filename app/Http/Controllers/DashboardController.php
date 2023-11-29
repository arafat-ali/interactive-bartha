<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function home(){
        $posts = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->select('posts.*', 'users.id as userId', 'users.firstName', 'users.lastName', 'users.email')
                    ->orderBy('posts.id', 'DESC')
                    ->get();



        foreach($posts as $post){
            $post->post_created = Carbon::parse($post->created_at)->diffForHumans();
            $post->comments_count = DB::table('comments')->where('post_id', $post->id)->count();
        }
        return view('user.pages.home', ["data" => $posts]);
    }


}
