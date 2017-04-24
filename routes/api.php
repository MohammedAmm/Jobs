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
			
		
	



		
		Route::post('yes',function (Request $request){
					
				return 	json_encode(['user'=>['name'=>$request->input('name'),'email'=>$request->input('email')]]);
							

		});
    	