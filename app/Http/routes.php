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


// ========================
// WEB SITE ROUTES
// ========================

Route::get('', function () {
	return redirect('/dashboard');
});

Route::group(['as' => 'web.'], function () {
	Route::get('confirm/{token}', ['as' => 'confirm', 'uses' => 'WebsiteController@confirm']);
	Route::post('confirm/{token}', ['as' => 'confirmPost', 'uses' => 'WebsiteController@confirmPost']);
});

// ========================
// AUTH ROUTES
// ========================

Route::group(['as' => 'auth.', 'prefix' => 'auth'], function(){
	Route::get('', function () {
		return redirect('/dashboard');
	});
	Route::get('login', ['as' => 'index', 'uses' => 'UserController@auth']);
	Route::post('login', ['as' => 'login', 'uses' => 'UserController@login']);
	Route::get('logout', ['as' => 'logout', 'uses' => 'UserController@logout']);
	Route::group(['as' => 'password.', 'prefix' => 'password'], function(){
		Route::get('request', ['as' => 'request', 'uses' => 'UserController@passwordRequest']);
		Route::post('request', ['as' => 'requestsubmit', 'uses' => 'UserController@passwordRequestPost']);
		Route::get('reset/{token}', ['as' => 'reset', 'uses' => 'UserController@passwordResetToken']);
		Route::post('reset/{token}', ['as' => 'reset', 'uses' => 'UserController@passwordResetTokenPost']);
	});
});

// ========================
// WEB ADMIN ROUTES
// ========================

Route::group(['as' => 'dashboard.', 'prefix' => 'dashboard', 'middleware' => 'auth'], function(){
	Route::get('', ['as' => 'dashboard', 'uses' => 'DashboardController@dashboard']);

	Route::group(['as' => 'password.', 'prefix' => 'password'], function(){
		Route::get('edit', ['as' => 'edit', 'uses' => 'UserController@passwordEdit']);
		Route::post('edit', ['as' => 'update', 'uses' => 'UserController@passwordUpdate']);
		Route::get('reset/{id}', ['as' => 'reset', 'uses' => 'UserController@passwordReset']);
	});

	Route::group(['as' => 'user.', 'prefix' => 'user', 'middleware' => 'admin'], function(){
		Route::get('search', ['as' => 'filter', 'uses' => 'UserController@filter']);
		Route::get('create', ['as' => 'create', 'uses' => 'UserController@create']);
		Route::post('create', ['as' => 'store', 'uses' => 'UserController@store']);
		Route::get('edit', ['as' => 'edit', 'uses' => 'UserController@edit']);
		Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'UserController@edit']);
		Route::post('edit', ['as' => 'update', 'uses' => 'UserController@update']);
		Route::post('edit/{id}', ['as' => 'profileUpdate', 'uses' => 'UserController@update']);
		Route::get('', ['as' => 'profile', 'uses' => 'UserController@profile']);
		Route::get('{id}', ['as' => 'profile', 'uses' => 'UserController@profile']);
		Route::get('status/{type}/{id}', ['as' => 'delete', 'uses' => 'UserController@status']);
	});

	Route::group(['as' => 'guests.', 'prefix' => 'guests', 'middleware' => 'admin'], function () {
		Route::get('', ['as' => 'index', 'uses' => 'GuestsController@index']);
		Route::get('search', ['as' => 'filter', 'uses' => 'GuestsController@filter']);
		Route::get('create', ['as' => 'create', 'uses' => 'GuestsController@create']);
		Route::post('store', ['as' => 'store', 'uses' => 'GuestsController@store']);
		Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'GuestsController@edit']);
		Route::post('update/{id}', ['as' => 'update', 'uses' => 'GuestsController@update']);
		Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'GuestsController@delete']);
		Route::get('download', ['as' => 'download', 'uses' => 'GuestsController@download']);
		Route::get('download/{id}', ['as' => 'download', 'uses' => 'GuestsController@download']);
	});

	Route::group(['as' => 'events.', 'prefix' => 'events', 'middleware' => 'admin'], function () {
		Route::get('', ['as' => 'index', 'uses' => 'EventsController@index']);
		Route::get('search', ['as' => 'filter', 'uses' => 'EventsController@filter']);
		Route::get('create', ['as' => 'create', 'uses' => 'EventsController@create']);
		Route::post('store', ['as' => 'store', 'uses' => 'EventsController@store']);
		Route::get('edit/{id}', ['as' => 'edit', 'uses' => 'EventsController@edit']);
		Route::post('update/{id}', ['as' => 'update', 'uses' => 'EventsController@update']);
		Route::get('delete/{id}', ['as' => 'delete', 'uses' => 'EventsController@delete']);
	});

	Route::group(['middleware' => 'admin'], function(){
		Route::get('users', ['as' => 'users', 'uses' => 'UserController@index']);
		Route::post('users', ['as' => 'filter', 'uses' => 'UserController@filter']);
	});
});

// ========================
// API ROUTES
// ========================

Route::group(['as' => 'api.', 'prefix' => 'api', 'middleware' => 'auth'], function () {

	Route::group(['as' => 'v2.', 'prefix' => 'v2'], function () {

		// Route::group(['as' => 'atrTable.', 'prefix' => 'atr-table'], function () {
		// 	Route::post('lookup-by-date', ['as' => 'lookupByDate', 'uses' => 'AtrTableController@lookupByDate']);
		// });
	});
});
