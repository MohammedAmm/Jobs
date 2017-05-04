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

    	Route::post('user_reg','ApiController@user_reg');
			
    	Route::post('worker_reg','ApiController@worker_reg');
		Route::post('login','ApiController@login');	
		Route::post('worker_update','ApiController@worker_update');
		Route::post('user_update','ApiController@user_update');	
		Route::post('user_retrive','ApiController@user_retrive');
		Route::post('worker_retrive','ApiController@worker_retrive');


		
		Route::post('yes',function (Request $request){

			if($user=\Auth::guard('api')->user())
			{		
				
				 
					// return 	json_encode(['user'=>['name'=>$request->input('user.name'),'email'=>$request->input('user.email')]]);
					// return $request->header('Authorization');
				return $user->name ; 

			}
			else
			{

				return  'not authenticated'; 

			}


		});
    	