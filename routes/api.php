<?php

use Illuminate\Http\Request;




    	Route::any('user_reg','ApiController@user_reg');  //post
			
    	Route::any('worker_reg','ApiController@worker_reg');	//post
		Route::any('login','ApiController@login');	// post
		Route::any('worker_update','ApiController@worker_update'); //put
		Route::any('user_update','ApiController@user_update');	//put
		Route::any('password_reset','ApiController@password_reset'); //put
		Route::get('search','ApiController@search'); //get
		Route::any('rate','ApiController@rate');	//post
		Route::any('category','ApiController@category'); //get
		Route::any('delete','ApiController@delete');//delete
		Route::get('forget_first','ApiController@forget_first');//get
		Route::any('forget_second','ApiController@forget_second');//post

		
// just for test

		Route::get('ts',function (Request $request)   
		{
return json_encode(DB::table('workers')->where([['job_id',$request->input('job_id')],['address_id',$request->input('address_id')]])->sharedlock()->skip($request->input('try')*10)->take(10)->get());
		});


		Route::any('test','ApiController@test');

























    	

    	