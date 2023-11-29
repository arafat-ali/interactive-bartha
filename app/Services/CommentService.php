<?php


namespace App\Services;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentService{

    public function store(Array $data, Post $post){
        $success = DB::table('comments')->insert([
            ...$data,
            'post_id'=>$post->id,
            'user_id'=>Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $success;
    }

}
