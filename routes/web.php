<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Auth;
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
    return view('blog.index');
})->name(('blog.index'));

Route::get('/register', function () {
    return view('blog.register');
})->name('blog.register');

Route::get('/create', function () {
    $all_posts = (new PostController())->index();
    return view('blog.create', ['all_posts' => $all_posts, 'auth' => Auth::check()]);
})->name('blog.create');

Route::get('/post/{id}', [PostController::class, 'show'])->name(('blog.view')); // view post by ID 
Route::get('/edit/{postId}', [PostController::class, 'read'])->name('blog.edit');