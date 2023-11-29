<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostFormRequest;
use App\Http\Requests\EditPostFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
class PostController extends Controller
{

    public function show($uuid){
        $post = DB::table('posts')
                    ->join('users', 'users.id', 'posts.user_id')
                    ->where('posts.uuid', $uuid)
                    ->select('posts.*', 'users.id as userId', 'users.firstName', 'users.lastName', 'users.email')
                    ->first();
        return view('user.pages.post', ["post" => $post]);
    }

    public function create(CreatePostFormRequest $request):RedirectResponse{
        $data = $request->safe()->only('title');
        $success = DB::table('posts')->insert([
            ...$data,
            'uuid' => Str::uuid(),
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if($success) {
            flash()->options(['timeout' => 2000])->addSuccess('Post created successfully!');
            return redirect()->intended('user');
        }
        flash()->options(['timeout' => 2000])->addWarning('Post creation failed');
        return back()->withInput();
    }


    public function edit($uuid){
        $post = DB::table('posts')->where('uuid', $uuid)->first();
        return view('user.pages.editPost', ["post" => $post]);
    }


    public function update(EditPostFormRequest $request, $uuid):RedirectResponse{
        $data = $request->safe()->only('title');
        $success = DB::table('posts')->where('uuid', $uuid)->update([
            ...$data,
            'updated_at' => Carbon::now()
        ]);

        if($success) {
            flash()->options(['timeout' => 2000])->addSuccess('Post updated successfully!');
            return redirect()->route('user');
        }
        flash()->options(['timeout' => 2000])->addWarning('Post updation failed');
        return back()->withInput();
    }

    public function delete($uuid){
        $success = DB::table('posts')->where('uuid', $uuid)->delete();
        if($success){
            flash()->options(['timeout' => 2000])->addWarning('Post deleted successfully!');
            return redirect()->route('user');
        }
        flash()->options(['timeout' => 2000])->addError('Post Deletion failed');
        return back()->withInput();
    }


}
