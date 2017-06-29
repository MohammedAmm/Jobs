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

    	Route::any('user_reg','ApiController@user_reg');  //post
			
    	Route::any('worker_reg','ApiController@worker_reg');	//post
		Route::any('login','ApiController@login');	// post
		Route::any('worker_update','ApiController@worker_update'); //put
		Route::post('user_update','ApiController@user_update');	//put
		Route::post('user_retrieve','ApiController@user_retrive'); //get
		Route::post('worker_retrieve','ApiController@worker_retrive'); //get
		Route::post('password_reset','ApiController@password_reset'); //put
		Route::post('search','ApiController@search'); //get
		Route::post('rate','ApiController@rate');	//post
		Route::post('profileUp','ApiController@profileUp'); //post	
		Route::post('category','ApiController@category'); //get




		
// just for test

		Route::get('ts',function (Request $request)   
		{
return json_encode(DB::table('workers')->where([['job_id',$request->input('job_id')],['address_id',$request->input('address_id')]])->sharedlock()->skip($request->input('try')*10)->take(10)->get());
		});


		Route::any('test','ApiController@test');

























    	

    	