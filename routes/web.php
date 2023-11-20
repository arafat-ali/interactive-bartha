<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'postRegister']);

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('post-login');



Route::group([
    "middleware" => [
        "auth",
    ],
    "prefix"     => "user/"
], function () {
    Route::get('/', [UserController::class, 'home'])->name('user');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [UserProfileController::class, 'edit']);
    Route::put('/profile/edit', [UserProfileController::class, 'update']);

    Route::post('/post/create', [PostController::class, 'create']);
    Route::get('/post/details/{id}', [PostController::class, 'show']);
    Route::get('/post/edit/{id}', [PostController::class, 'edit']);
    Route::put('/post/edit/{id}', [PostController::class, 'update']);
    Route::delete('/post/delete/{id}', [PostController::class, 'delete']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
