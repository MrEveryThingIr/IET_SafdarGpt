<?php
use App\Core\Route;


Route::get('/IETDev/create/form', 'IETDevController@showCreateFormForm')->name('ietdev.create.form');
Route::get('/IETDev/form/example', 'IETDevController@showExampleForm')->name('ietdev.example.form');
