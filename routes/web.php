<?php
use App\Core\Route;
use App\Models\IETAnnounce;

Route::get('/','AuthController@home')->name('iethome');
// users
Route::get('/user/{user_id}/profile/{feature}','ProfileController@center')->name('user.profile');
Route::get('/auth/register', 'AuthController@showRegisterForm')->name('auth.register');
Route::post('/auth/register', 'AuthController@register');

Route::get('/auth/login', 'AuthController@showLoginForm')->name('auth.login');
Route::post('/auth/login', 'AuthController@login')->name('auth.login.post');

Route::post('/auth/logout', 'AuthController@logout')->name('auth.logout');
Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');

// IETAnnounces
Route::get('/ietannounce/create', 'IETAnnounceController@create')->name('ietannounce.create');
Route::post('/ietannounce/create', 'IETAnnounceController@store')->name('ietannounce.store');

Route::get('/ietannounce/mine', 'IETAnnounceController@mine')->name('ietannounce.mine');
Route::get('/ietannounce/show/{id}', 'IETAnnounceController@show')->name('ietannounce.show');
Route::get('/ietannounce/edit/{id}', 'IETAnnounceController@edit')->name('ietannounce.edit');
Route::post('/ietannounce/update/{id}', 'IETAnnounceController@update')->name('ietannounce.update');
Route::post('/ietannounce/delete/{id}', 'IETAnnounceController@delete')->name('ietannounce.delete');

Route::get('/ietannounce/filtered/{filter}', 'AuthController@filteredAnnounces')->name('ietannounce.filtered'); 
Route::get('/ietannounce/all','AuthController@allAnnounces')->name('ietannounce.all');

// CommentsOnAnnounces
Route::get('/ietannounce/{announce_id}/add_comment', 'IETAnnounceCommentController@addCommentOnAnnounce')->name('ietannounce.add_comment'); 
Route::post('/ietannounce/{announce_id}/store_comment', 'IETAnnounceCommentController@storeComment')->name('ietannounce.store_comment'); 


// contracts
Route::get('/contracts/create', 'ContractController@createContract')->name('ietannounce.createForm'); 
