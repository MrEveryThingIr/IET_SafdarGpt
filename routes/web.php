<?php
use App\Core\Route;

// Define route here or in routes/web.php
Route::get('/test', 'TestController@testMethod');
Route::get('/index','HomeController@index')->name('home.index');
Route::get('/','HomeController@index')->name('home');
Route::get('/registration','HomeController@registration')->name('home.register');
Route::get('/log-in','HomeController@login')->name('home.login');

