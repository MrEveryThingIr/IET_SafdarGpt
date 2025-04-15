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

// ─── Layout Builder ──────────────────────────────────────────────────────────
Route::get('gui/layout/create', 'DeveloperInterfaceControllers\\LayoutBuilderController@create')->name('gui.layout.create');
Route::post('gui/layout/store', 'DeveloperInterfaceControllers\\LayoutBuilderController@store')->name('gui.layout.store');

// ─── Navbar ───────────────────────────────────────────────────────────────────
Route::get('gui/navbar/create', 'DeveloperInterfaceControllers\\NavbarController@create')->name('gui.navbar.create');
Route::get('gui/navbar/index', 'DeveloperInterfaceControllers\\NavbarController@index')->name('gui.navbar.index');
Route::get('gui/navbar/style', 'DeveloperInterfaceControllers\\NavbarController@style')->name('gui.navbar.style');
Route::get('gui/navbar/script', 'DeveloperInterfaceControllers\\NavbarController@script')->name('gui.navbar.script');

// ─── Sidebar ──────────────────────────────────────────────────────────────────
Route::get('gui/sidebar/create', 'DeveloperInterfaceControllers\\SidebarController@create')->name('gui.sidebar.create');
Route::get('gui/sidebar/index', 'DeveloperInterfaceControllers\\SidebarController@index')->name('gui.sidebar.index');
Route::get('gui/sidebar/style', 'DeveloperInterfaceControllers\\SidebarController@style')->name('gui.sidebar.style');
Route::get('gui/sidebar/script', 'DeveloperInterfaceControllers\\SidebarController@script')->name('gui.sidebar.script');

// ─── Form ─────────────────────────────────────────────────────────────────────
Route::get('gui/form/create', 'DeveloperInterfaceControllers\\FormController@create')->name('gui.form.create');
Route::get('gui/form/index', 'DeveloperInterfaceControllers\\FormController@index')->name('gui.form.index');
Route::get('gui/form/style', 'DeveloperInterfaceControllers\\FormController@style')->name('gui.form.style');
Route::get('gui/form/script', 'DeveloperInterfaceControllers\\FormController@script')->name('gui.form.script');

// ─── Preview Page ─────────────────────────────────────────────────────────────
Route::get('gui/preview', 'DeveloperInterfaceControllers\\PreviewController@index')->name('gui.preview');

Route::post('gui/json/save', 'DeveloperInterfaceControllers\\JsonAssetController@save')->name('gui.json.save');
Route::get('gui/json/fetch', 'DeveloperInterfaceControllers\\JsonAssetController@fetch')->name('gui.json.fetch');
