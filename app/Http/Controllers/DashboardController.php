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

        $posts = collect($posts)->map(function ($item){
            $item->comments_count = DB::table('comments')->where('post_id', $item->id)->count();
            return $item;
        });

        // foreach($posts as $post){
        //     $post->comments_count = DB::table('comments')->where('post_id', $post->id)->count();
        // }

        // $posts = DB::table('posts')
        //             ->select('posts.*', 'users.id as userId', 'users.firstName', 'users.lastName', 'users.email', DB::raw('count(comments.id) as comments_count'))
        //             ->join('users', 'users.id', 'posts.user_id')
        //             ->leftJoin('comments', 'posts.id', '=', 'comments.post_id')
        //             ->groupBy('posts.id')
        //             ->orderBy('posts.id', 'DESC')
        //             ->get();


        return view('user.pages.home', ["data" => $posts]);
    }


}
