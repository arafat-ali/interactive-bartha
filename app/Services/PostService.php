<?php


namespace App\Services;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class PostService{

    public function show($uuid):object{
        $post = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->where('posts.uuid', $uuid)
                    ->select('posts.*', 'users.id as userId', 'users.uuid as userUuid', 'users.firstName', 'users.lastName', 'users.email')
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


    public function postsWithCommentsCount(){
        $posts = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->select('posts.*', 'users.id as userId', 'users.uuid as userUuid', 'users.firstName', 'users.lastName', 'users.email')
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

        return $posts;

    }


    public function postsWithCommentsCountByUser($uuid){
        $user = User::where('uuid', $uuid)->first();
        $posts = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->select('posts.*', 'users.id as userId', 'users.uuid as userUuid', 'users.firstName', 'users.lastName', 'users.email')
                    ->orderBy('posts.id', 'DESC')
                    ->where('users.id', $user->id)
                    ->get();

        $total_comments = DB::table('comments')->where('user_id', $user->id)->count();

        $posts = collect($posts)->map(function ($item){
            $item->comments_count = DB::table('comments')->where('post_id', $item->id)->count();
            return $item;
        });

        $user->total_posts = sizeOf($posts);
        $user->total_comments =$total_comments;
        $user->posts = $posts;
        return $user;

    }



    public function updateViews($post){
        return DB::table('posts')->where('id', $post->id)->update(['views' => $post->views+1]);
    }

}
