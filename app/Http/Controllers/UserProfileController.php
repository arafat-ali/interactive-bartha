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
        $data = $request->safe()->only(['firstName', 'lastName', 'bio']);
        if(isset($request->password)) $data['password'] = bcrypt($request->password);

        $user = user::find(Auth::user()->id);
        $success = $user->update($data);
        if($request->hasFile('avatar')){
            $user->addMedia($request->file('avatar'))->toMediaCollection();
        }

        if(!$success){
            flash()->options(['timeout' => 2000])->addWarning('Profile update failed');
            return back()->withInput();
        }
        flash()->options(['timeout' => 2000])->addSuccess('Profile successfully updated!');
        return redirect()->route('profile', Auth::user()->uuid);
    }


    public function search(Request $request){
        $searchText = $request->search_text;
        $searchFields = ['firstName', 'lastName', 'email'];
        $users = User::with('posts', 'comments')->where(function($q) use($searchFields, $searchText){
            foreach($searchFields as $field) $q->orWhere($field, 'like', "%{$searchText}%");
        })->get();

        return view('user.pages.listUsers', ["data"=>$users]);
    }


}
