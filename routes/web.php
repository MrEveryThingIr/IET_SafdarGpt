<?php
use App\Core\Route;

Route::get('/','AuthController@home')->name('iethome');
// users
Route::get('/auth/register', 'AuthController@showRegisterForm')->name('auth.register');
Route::post('/auth/register', 'AuthController@register');

Route::get('/auth/login', 'AuthController@showLoginForm')->name('auth.login');
Route::post('/auth/login', 'AuthController@login')->name('auth.login.post');

Route::get('/auth/logout', 'AuthController@logout')->name('auth.logout');
Route::get('/dashboard', 'AuthController@dashboard')->name('ietdashboard');




Route::get('/ietpost/create', 'PostController@createPostForm')->name('ietpost.create');
Route::post('/ietpost/store', 'PostController@storePost')->name('ietpost.store');
Route::get('/ietpost/all', 'PostController@index')->name('ietpost.all');
Route::get('/ietpost/my', 'PostController@myPosts')->name('ietpost.my');
Route::get('/ietpost/archived', 'PostController@myArchivedPosts')->name('ietpost.archived');
Route::get('/ietpost/{id}', 'PostController@singlePost')->name('ietpost.single');


Route::get('/ietmeeting/create', 'MeetingController@createForm')->name('ietmeeting.create');
Route::post('/ietmeeting/store', 'MeetingController@store')->name('ietmeeting.store');
Route::get('/ietmeeting/my', 'MeetingController@myMeetings')->name('ietmeeting.my');
Route::get('/ietmeeting/show/{id}', 'MeetingController@show')->name('ietmeeting.show');
Route::get('/meetings/join/{id}', 'MeetingController@join')->name('ietmeeting.join');
