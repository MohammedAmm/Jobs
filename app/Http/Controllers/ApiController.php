<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ApiController extends Controller
{
     public function user_reg(Request $request)
    {
    	

           

        
        try {
            
            $token =str_random(60);

        $id=DB::table('users')->insertGetId(

        [
                'api_token'=>$token,
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role_id' => 2,
                'password' => bcrypt($request->input('password')),
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

            ]);



                return json_encode(['user'=>['name'=>$request->input('name'),'api_token'=>$token,'id'=>$id]]);

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
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role_id' => 1,
                'password' => bcrypt($request->input('password')),
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

            ]);


             $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
             $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
            DB::table('workers')->insert(

                [
       

                'user_id'=>$id,
                'job_id'=>$job_id,
                'phone'=>$request->input('phone'),
                'address_id'=>$address_id,
                'created_at'=>\Carbon\Carbon::now(),
                'updated_at'=>\Carbon\Carbon::now()

                ]);




        DB::commit();
           
            
                 return json_encode(['worker'=>['name'=>$request->input('name'),'api_token'=>$token,'id'=>$id]]);


            } 


            catch (\Exception $e) 

            {
                DB::rollBack();
                return 'worker registeration error' ;
            }
    }




     public function login(Request $request)
    {
        try 
        {
             if($user=DB::table('users')->where('email',$request->input('email'))->sharedlock()->first())
             {

                if (\Hash::check($request->input('password'),$user->password)) 
                {
                    return json_encode(['user'=>['id'=>$user->id,'api_token'=>$user->api_token,'name'=>$user->name,'role_id'=>$user->role_id]]
);
                }
                else 
                {

                    return 'wrong password' ;
                }

             }
             else 
             {


                return 'wrong email' ;
             }

             
            
        }
         catch (\Exception $e) 

        {
            return 'login error' ;
        }
    }


}
