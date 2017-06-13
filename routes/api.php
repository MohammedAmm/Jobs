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
		Route::post('user_retrieve','ApiController@user_retrive');
		Route::post('worker_retrieve','ApiController@worker_retrive');
		Route::post('password_reset','ApiController@password_reset');
		Route::post('search','ApiController@search');
		
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


		Route::get('ts',function (Request $request)
		{
return json_encode(DB::table('workers')->where([['job_id',$request->input('job_id')],['address_id',$request->input('address_id')]])->sharedlock()->skip($request->input('try')*10)->take(10)->get());
		});
    	
    	