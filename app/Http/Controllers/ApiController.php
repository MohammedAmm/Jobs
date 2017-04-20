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
                'role_id' => 2,
                'password' => bcrypt($request->input('user.password')),
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

            ]);



                return json_encode(['user'=>['name'=>$request->input('user.name'),'api_token'=>$token,'id'=>$id]]);

        }

         catch (\Exception $ex) {
            
            return 'user registeration error';            
        }


    }


    public function worker_reg(Request $request)
    {
          
            try 
            {
                      
             
             $token =str_random(60);                       
             DB::beginTransaction();
                $id=DB::table('users')->insertGetId(

        [
                'api_token'=>$token,
                'name' => $request->input('worker.name'),
                'email' => $request->input('worker.email'),
                'role_id' => 1,
                'password' => bcrypt($request->input('worker.password')),
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

            ]);

            DB::table('workers')->insert(


                [

                'user_id'=>$id,
                'job_id'=>$request->input('worker.job_id'),
                'phone'=>$request->input('worker.phone'),
                'address_id'=>$request->input('worker.address_id'),
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

                ]);




        DB::commit();
           


                return json_encode(['worker'=>['name'=>$request->input('worker.name'),'api_token'=>$token,'id'=>$id,'job_id'=>$request->input('worker.job_id')]]);


            } 


            catch (\Exception $e) 

            {
                DB::rollback();
                return 'worker registeration error' ;
            }
    }


}
