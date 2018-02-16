<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('post/comments/{postId}', function(){
    
});

Route::get('blog/view/{blogId}', ['uses'=>'BlogsController@index'])->name('blog');

Route::get('blog/create', 'BlogsController@create')->name('blog/create');

Route::post('blog/create', 'BlogsController@store')->name('blog/create');

Route::get('blog/delete/{blogId}', 'BlogsController@destroy')->name('blog.delete');

Route::get('post/view/{postId}', 'BlogPostController@index')->name('post');

Route::post('post/view/{postId}', 'CommentsController@store')->name('post');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home/{$blogId}',['uses'=>'BlogsController@index' ] );

Route::get('/post/create/{blogId}', 'BlogPostController@create')->name('post.create');

Route::post('/post/create/{blogId}', 'BlogPostController@store')->name('post.create');

Route::get('post/edit/{postId}', 'BlogPostController@edit')->name('post.edit');

Route::post('post/edit/{postId}', 'BlogPostController@update')->name('post.edit');

Route::get('post/delete/{postId}', 'BlogPostController@destroy')->name('post.delete');

Route::get('/dashboard', 'BlogsController@show')->name('dashboard');


Route::get('/error}', function() {
    return view('error');
})->name('error');


// Route::get('following/{userId}', function(){
    
// });




