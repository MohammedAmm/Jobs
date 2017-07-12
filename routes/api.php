<?php

use Illuminate\Http\Request;


		Route::any('get','ApiController@get'); 										//get	

    	Route::any('user_reg','ApiController@user_reg');  							//post
			
    	Route::any('worker_reg','ApiController@worker_reg');						//post
		
		Route::any('login','ApiController@login');									// post
		
		Route::any('worker_update','ApiController@worker_update'); 					//put
		
		Route::any('user_update','ApiController@user_update');						//put
		
		Route::any('profile_update','ApiController@profile_update');				//post

		Route::any('password_reset','ApiController@password_reset'); 				//put
		
		Route::any('search','ApiController@search'); 								//get
		
		Route::any('getc','ApiController@getc');

		Route::any('rate','ApiController@rate');									//post
				
		Route::any('delete','ApiController@delete');								//delete
		
		Route::any('forget_first','ApiController@forget_first');					//get
		
		Route::any('forget_second','ApiController@forget_second');					//post

		
// just for test

		Route::get('up',function (Request $request)   

		{

			return view('up');
		});

		Route::any('test','ApiController@test');
























    	

    	