<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->only(['firstName', 'lastName', 'email']);
        $user = User::create([
            ...$data,
            'uuid' => Str::uuid(),
            'password' => Hash::make($request->password)
        ]);
        $success = DB::table('users')->insert();

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);



        if($success) {
            flash()->addSuccess('Registration successfully!');
            return redirect()->route('login');
        }
        flash()->addWarning('Registration failed');
        return back()->withInput();
    }
}
