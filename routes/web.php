<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/','HomeController@index');
Route::get('/home', 'HomeController@index');
Route::resource('roles','RoleController');
Route::group(['middleware'=>'admin'],function()
{
	# code...
	Route::get('/adminpanel','AdminController@index');
	Route::resource('/adminpanel/users','UsersController');
});