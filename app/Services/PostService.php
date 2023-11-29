<?php


namespace App\Services;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostService{

    public function show($uuid):object{
        $post = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->where('posts.uuid', $uuid)
                    ->select('posts.*', 'users.id as userId', 'users.firstName', 'users.lastName', 'users.email')
                    ->first();

        //Update Views of Post of Other users
        if($post->user_id !== Auth::user()->id){
            if($this->updateViews($post)){
                $post->views += 1;
            }
        }

        $comments = DB::table('comments')
                    ->join('users', 'users.id', 'comments.user_id')
                    ->select('comments.*','firstName', 'lastName', 'email')
                    ->where('comments.post_id', $post->id)
                    ->get();

        $post->comments = $comments;
        return $post;
    }

    public function create(Array $data):bool{
        $success = DB::table('posts')->insert([
            ...$data,
            'uuid' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return $success;
    }



    public function updateViews($post){
        return DB::table('posts')->where('id', $post->id)->update(['views' => $post->views+1]);
    }

}
