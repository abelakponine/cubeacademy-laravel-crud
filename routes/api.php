<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function() {
    /** User Authentication */
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    /** Posts */
    Route::get('/posts', [PostController::class, 'index']); // get all posts

    Route::middleware('auth:sanctum')->post('/create', [PostController::class, 'create'])->name('api.create'); // create post
    Route::middleware('auth:sanctum')->post('/update', [PostController::class, 'update'])->name('api.update'); // update post
    Route::middleware('auth:sanctum')->post('/delete', [PostController::class, 'delete'])->name('api.delete'); // delete post
});