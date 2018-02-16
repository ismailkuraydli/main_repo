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

Route::get('/', 'WelcomePageController@index');

Route::get('/dashboard','DashboardController@index');

Route::get('/profile/view','ProfileViewController@index');

Route::get('/explore','ExploreController@index');

Route::get('/profile/guest/view/{$userId}','ProfileViewController@guest');

Route::get('/profile/edit', 'ProfileEditController@edit')->name('profile.edit');

Route::post('/profile/edit','ProfileEditController@update')->name('profile.edit');

Route::get('/post/view/{postId}','PostViewController@index')->name('post.view');

Route::post('/post/view/{postId}','PostViewController@comment')->name('post.comment');

Route::post('/post/reply/{commentId}','PostViewController@reply')->name('post.reply');

Route::get('/post/like/{postId}','PostViewController@like')->name('post.like');

Route::get('/post/unlike/{postId}','PostViewController@unLike')->name('post.unlike');

Route::get('/follow/user/{userID}','PostViewController@follow')->name('user.follow');

Route::get('/post/create','PostCreateController@create')->name('post.create');

Route::post('/post/create','PostCreateController@store')->name('post.create');

Route::get('/inbox','InboxController@index');

Route::get('/direct/message/{userId}','DirectMessageController@index')->name('direct.message');

Route::post('/direct/message/{userId}','DirectMessageController@send')->name('direct.message');
// Route::get('/image/filers','ImageFiltersController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
