<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::prefix('/post')->middleware('auth:api')->group(function () {
    Route::get('/{postId}', [PostController::class, 'showPostDetail'])->name('post.get-post-detail');
    Route::get('/{postId}/comment', [PostController::class, 'showPostComment'])->name('post.get-post-comment');
    Route::post('/', [PostController::class, 'createPost'])->name('post.create-post');
    Route::post('/{postId}/comment', [PostController::class, 'commentPost'])->name('post.comment-post');
    Route::post('/{postId}/comment/{commentId}/reply', [PostController::class, 'replyCommenttedPost'])->name('post.reply-commentted-post');
});

Route::prefix('/test')->middleware(['auth:api', 'api.admin'])->group(function () {
    Route::get('/article', function () {
        return response(["data" => 'OK', "message" => 'ok'], 200, [
            "Content-Type" => "application/json"
        ]);
    });
});
