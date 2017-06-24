<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 

*/

    	Route::get('user_reg','ApiController@user_reg');
			
    	Route::post('worker_reg','ApiController@worker_reg');
		Route::post('login','ApiController@login');	
		Route::post('worker_update','ApiController@worker_update');
		Route::post('user_update','ApiController@user_update');	
		Route::post('user_retrieve','ApiController@user_retrive');
		Route::post('worker_retrieve','ApiController@worker_retrive');
		Route::post('password_reset','ApiController@password_reset');
		Route::post('search','ApiController@search');
		Route::post('rate','ApiController@rate');
		Route::post('profileUp','ApiController@profileUp');	
		Route::post('category','ApiController@category');




		


		Route::get('ts',function (Request $request)  // just for test 
		{
return json_encode(DB::table('workers')->where([['job_id',$request->input('job_id')],['address_id',$request->input('address_id')]])->sharedlock()->skip($request->input('try')*10)->take(10)->get());
		});






























    	
    			Route::get('up','ApiController@test1');   //just for test 

    	