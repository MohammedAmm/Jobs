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

Route::middleware('auth:api')->get('/user', function () {
    return $request->user();

});

    	Route::post('user_reg','ApiController@user_reg');

		
		Route::post('yes',function (Request $request){
		return $request->input('data.1');
		//return json_encode(['data'=>[1=>'one',2=>'two',3=>'three']]);
		})->middleware('auth:api');
    	