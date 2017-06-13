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
Route::post('/search','SearchController@search');
Route::get('/search','HomeController@index');
Route::get('/worker/{id}','ProfileController@show')->name('profile');
Route::get('profile', 'ProfileController@profile');
Route::post('profile', 'ProfileController@update_info');
Route::get('/results', function() {
    //
    return view('results');
});
Route::get('/home', 'HomeController@index');
Route::resource('ratings', 'RatingController');
Route::group(['middleware'=>'admin'],function()
{
	# code...
	Route::get('/adminpanel','AdminController@index');
	Route::resource('/adminpanel/users','UsersController');
	Route::resource('/adminpanel/jobs','JobController');
	Route::resource('/adminpanel/addresses','AddressController');


});