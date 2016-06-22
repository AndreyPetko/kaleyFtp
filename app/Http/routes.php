<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


View::composer('site.*', function($view){
	$view->with('text', app('App\Text'));
	$view->with('categoriesUrls', App\Category::getCategoriesUrls());
});


Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');

Route::get('auth/login', 'Auth\AuthController@getAdminLogin');

// Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::post('login', 'Auth\AuthController@Authenticate');

Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::controller('ajax', 'AjaxController');

Route::controller('admin/components', 'ComponentsController');

Route::controller('/admin/articles', 'AdminArticlesController');

Route::controller('admin/reviews', 'ReviewsController');

Route::controller('/admin/texts', 'TextsController');

Route::controller('/admin/users', 'UsersController');


Route::get('/articles', 'ArticlesController@index');
Route::get('/article/{url}', 'ArticlesController@getArticle');


Route::controller('/orders', 'OrdersController');
Route::controller('/admin/orders', 'AdminOrdersController');

Route::controller('admin', 'AdminController');


Route::group(['nocsrf' => true],function(){
	Route::get('/file/upload', 'FileController@upload');
	Route::post('/file/upload', 'FileController@upload');
});


Route::controller('dashboard', 'DashboardController');





Route::controller('/', 'HomeController');







