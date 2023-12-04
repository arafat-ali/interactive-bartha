<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Services\PostService;

class PostController extends Controller
{

    private PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function show($uuid){
        $data = $this->postService->show($uuid);
        return view('user.pages.post', $data);
    }

    public function store(CreatePostRequest $request):RedirectResponse{
        $data = $request->safe()->only('title');
        $success = $this->postService->store($data, $request->hasFile('post_image') ? $request->file('post_image') : null);
        if(!$success) {
            flash()->options(['timeout' => 2000])->addWarning('Post creation failed');
            return back()->withInput();
        }
        flash()->options(['timeout' => 2000])->addSuccess('Post created successfully!');
        return back();

    }


    public function edit($uuid){
        $post = DB::table('posts')->where('uuid', $uuid)->first();
        return view('user.pages.editPost', ["post" => $post]);
    }


    public function update(EditPostRequest $request, $uuid):RedirectResponse{
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
