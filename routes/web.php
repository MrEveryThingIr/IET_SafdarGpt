<?php
use App\Core\Route;
use App\Models\IETAnnounce;

Route::get('/','AuthController@home')->name('iethome');
// users
Route::get('/auth/register', 'AuthController@showRegisterForm')->name('auth.register');
Route::post('/auth/register', 'AuthController@register');

Route::get('/auth/login', 'AuthController@showLoginForm')->name('auth.login');
Route::post('/auth/login', 'AuthController@login')->name('auth.login.post');

Route::get('/auth/logout', 'AuthController@logout')->name('auth.logout');
Route::get('/dashboard', 'AuthController@dashboard')->name('dashboard');

// IETAnnounces
Route::get('/ietannounce/create', 'IETAnnounceController@create')->name('ietannounce.create');
Route::post('/ietannounce/create', 'IETAnnounceController@store')->name('ietannounce.store');

Route::get('/ietannounce/mine', 'IETAnnounceController@mine')->name('ietannounce.mine');
Route::get('/ietannounce/show/{id}', 'IETAnnounceController@show')->name('ietannounce.show');
Route::get('/ietannounce/edit/{id}', 'IETAnnounceController@edit')->name('ietannounce.edit');
Route::post('/ietannounce/update/{id}', 'IETAnnounceController@update')->name('ietannounce.update');
Route::post('/ietannounce/delete/{id}', 'IETAnnounceController@delete')->name('ietannounce.delete');
// Optional for admin/overview
Route::get('/ietannounce/all', 'IETAnnounceController@all')->name('ietannounce.all'); 
