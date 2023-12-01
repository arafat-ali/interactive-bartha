<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserProfileFormRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\PostService;

class UserProfileController extends Controller
{
    public function show($uuid, PostService $postService){
        //data as User with posts
        $data = $postService->postsWithCommentsCountByUser($uuid);
        return view('user.pages.profile', ["data"=>$data]);
    }

    public function edit(){
        $user = Auth::user();
        return view('user.pages.editProfile', ["data"=>$user]);
    }

    public function update(UserProfileFormRequest $request){
        $user = Auth::user();
        $data = $request->only(['firstName', 'lastName', 'bio']);

        if(isset($request->password)){
            $data['password'] = bcrypt($request->password);
        }

        $success = DB::table('users')->where('id', $user->id)->update($data);
        if($success) return redirect()->route('profile')->with('message', 'Profile successfully updated!');
        return back()->withInput();
    }
}
