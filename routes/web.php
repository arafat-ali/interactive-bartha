<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

    // Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

require __DIR__.'/auth.php';
