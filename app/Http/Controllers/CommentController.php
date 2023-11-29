<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentRequest;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    public function store(CreateCommentRequest $request, $post_uuid){
        $post = Post::where('uuid', $post_uuid)->first();
        $success = $this->commentService->store($request->safe()->only('title'), $post);

        if($success) flash()->options(['timeout' => 2000])->addSuccess('Comment successfully done!');
        else flash()->options(['timeout' => 2000])->addWarning('Comment failed');

        return back();
    }


}
