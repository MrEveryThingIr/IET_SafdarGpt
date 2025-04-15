<?php
use App\Core\Route;

// Define route here or in routes/web.php
Route::get('/test', 'TestController@testMethod');
Route::get('/index','HomeController@index')->name('home.index');
Route::get('/','HomeController@index')->name('home');
Route::get('/registration','HomeController@registration')->name('home.register');
Route::get('/log-in','HomeController@login')->name('home.login');

Route::post('/user/store','UserController@register')->name('user.store');
Route::post('/loggedIn','UserController@login')->name('user.login');
Route::post('/loggedOut','UserController@logout')->name('user.logout');

Route::get('dashboard',"AuthenticatedControllers/DashboardController@index")
->name('dashboard.index');

Route::get('/profile','AuthenticatedControllers/ProfileController@profile')
->name('user.profile');


Route::get('profile/edit',"ProfileController@edit")->name('profile.edit');


Route::get('gui/layout/create', 'DeveloperInterfaceControllers\\LayoutBuilderController@create')->name('gui.layout.create');
Route::post('gui/layout/store', 'DeveloperInterfaceControllers\\LayoutBuilderController@store')->name('gui.layout.store');
Route::get('gui/layout/preview', 'DeveloperInterfaceControllers\\LayoutBuilderController@preview')->name('gui.layout.preview');
