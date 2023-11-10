<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterFormRequest;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{

    public function register(){
        return view('register');
    }

    public function postRegister(RegisterFormRequest $request):RedirectResponse{
        $user = $request->only(['firstName', 'lastName', 'email']);
        $success = DB::table('users')->insert([
            ...$user,
            'password' => bcrypt($request->password)
        ]);
        if($success) return redirect()->route('login')->with('message', 'Registration successful');
        return back()->withInput();
    }


    public function login(){
        return view('login');
    }

    public function postLogin(LoginFormRequest $request) : RedirectResponse{
        $email = $request->email;
        $user = DB::table('users')->where('email', $email)->first();
        if(!$user){
            return back()->withInput()->with('no_account_found', 'No account found with this email');
        }

        if (Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            return redirect()->intended('user');
        }

        return back()->withInput()->with('password_mismatch', 'Credential not matched!');
    }

    public function logout(Request $request): RedirectResponse{
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }



}
