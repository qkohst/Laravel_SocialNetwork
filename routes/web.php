<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/', function () {
    return view('auth/login');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/post', 'PostController');
Route::resource('/profile', 'ProfileController');
Route::post('/post/{post}/comment', 'CommentPostController@store')->name('post.comment.store');

Route::get('/commen/like/{id}', [
    'uses' => 'LikeCommentPostController@like',
    'as' => 'comment.like'
]);

Route::get('/post/like/{id}', [
    'uses' => 'LikePostController@like',
    'as' => 'post.like'
]);
