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

Route::get('/ietannounce/filtered/{filter}', 'IETAnnounceController@filteredAnnounces')->name('ietannounce.filtered'); 
Route::get('/ietannounce/all','IETAnnounceController@allAnnounces')->name('ietannounce.all');

// CommentsOnAnnounces
Route::get('/ietannounce/{announce_id}/add_comment', 'IETAnnounceCommentController@addCommentOnAnnounce')->name('ietannounce.add_comment'); 
Route::post('/ietannounce/{announce_id}/store_comment', 'IETAnnounceCommentController@storeComment')->name('ietannounce.store_comment'); 


// contracts
Route::get('/contracts/create', 'ContractController@createContract')->name('ietannounce.createForm'); 


// categories
Route::post('/ietcategories/main/store','CategoryController@storeMainCategory')->name('ietcategories.main.store');
Route::post('/ietcategories/main/delete/{id}','CategoryController@deleteMainCategory')->name('ietcategories.main.delete');
Route::post('/ietcategories/sub/delete/{id}','CategoryController@deleteSubCategory')->name('ietcategories.sub.delete');
Route::post('/ietcategories/sub/store','CategoryController@storeSubCategory')->name('ietcategories.sub.store');
Route::get('/ietcategories/create_main_category','CategoryController@createMainCategoryForm')->name('ietcategories.create_main');
Route::get('/ietcategories/{id}/show_main_category','CategoryController@showMainCategory')->name('ietcategories.show_main');
Route::get('/ietcategories/all_categories','CategoryController@allCategories')->name('ietcategories.all');
// chat rooms
Route::get('/ietchats/rooms/create', 'ChatController@createChatRoomForm')->name('ietchats.room.create'); 
Route::get('/ietchats/rooms/allChatRooms', 'ChatController@allChatRooms')->name('ietchats.room.all'); 
Route::get('/ietchats/rooms/show/{id}', 'ChatController@showChatRoom')->name('ietchats.room.show'); 
Route::post('/ietchats/rooms/create','ChatController@storeChatRoom')->name('ietchats.room.store');
Route::post('/ietchats/rooms/delete/{id}','ChatController@deleteChatRoom')->name('ietchats.room.delete');
Route::post('/ietchats/rooms/invite','ChatController@inviteUserToChatRoom')->name('ietchats.room.invite');
Route::post('/ietchats/rooms/send_message','ChatController@sendMessage')->name('ietchats.send_message');


// articles

Route::get('/ietarticles/all','ArticleController@allArticles')->name('ietarticles.all');
Route::get('/ietarticles/create','ArticleController@createArticleForm')->name('ietarticles.create');


Route::get('/ietarticles/show/{id}','ArticleController@showArticle')->name('ietarticles.show_article');
Route::post('/ietarticles/block/store','ArticleController@storeArticleBlock')->name('ietarticles.block.store');
Route::post('/ietarticles/block/delete/{id}','ArticleController@deleteArticleBlock')->name('ietarticles.block.delete');
Route::post('/ietarticles/store','ArticleController@storeArticle')->name('ietarticles.store');
