<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/edit-profile', [UserController::class, 'editProfile']);
});
