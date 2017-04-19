<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB ;
class ApiController extends Controller
{
     public function user_reg(Request $request)
    {
    	

           

        
        try {
            
            $token =str_random(60);

        $id=DB::table('users')->insertGetId(

        [
                'api_token'=>$token,
                'name' => $request->input('user.name'),
                'email' => $request->input('user.email'),
                'role_id' => $request->input('user.role_id'),
                'password' => bcrypt($request->input('user.password')),
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

            ]);



                return json_encode(['user'=>['name'=>$request->input('user.name'),'api_token'=>$token,'id'=>$id]]);

        }

         catch (Exception $e) {
            
            return 'some error';            
        }


    }
}
