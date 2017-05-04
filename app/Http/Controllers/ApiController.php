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
                'api_token'=>$token
                ,'name' => $request->input('name')
                ,'email' => $request->input('email')
                ,'role_id' => 2
                ,'password' => bcrypt($request->input('password'))
                ,'created_at'=>\Carbon\Carbon::now()
                ,'updated_at'=>\Carbon\Carbon::now()

            ]);



                return json_encode([
                    'user'=>[
                    'name'=>$request->input('name')
                    ,'api_token'=>$token
                    ,'id'=>$id

                    ]]);

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
                'api_token'=>$token
                ,'name' => $request->input('name')
                ,'email' => $request->input('email')
                ,'role_id' => 1
                ,'password' => bcrypt($request->input('password'))
                ,'created_at'=>\Carbon\Carbon::now()
                ,'updated_at'=>\Carbon\Carbon::now()

            ]);


             $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
             $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
            DB::table('workers')->insert(

                [
       

                'user_id'=>$id
                ,'job_id'=>$job_id
                ,'phone'=>$request->input('phone')
                ,'address_id'=>$address_id
                ,'created_at'=>\Carbon\Carbon::now()
                ,'updated_at'=>\Carbon\Carbon::now()

                ]);




        DB::commit();
           
            
                 return json_encode([
                    'worker'=>[
                    'name'=>$request->input('name')
                    ,'api_token'=>$token,'id'=>$id

                    ]]);


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
                    return json_encode([
                        'user'=>[
                        'id'=>$user->id
                        ,'api_token'=>$user->api_token
                        ,'name'=>$user->name
                        ,'role_id'=>$user->role_id

                        ]]);
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


    public function worker_update(Request $request)
    {
        try 
        {
            if ($user=\Auth::guard('api')->user())
            {
                $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
                $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
                 DB::beginTransaction();
                 
                 // {"job":"Carpenter" ,"name":"ahmed", "phone" : "01115693438" ,"address":"test","email":"ahmed@mail.com" }


                 DB::table('users')->where('api_token',$user->api_token)->lockForUpdate()->update([
                    'name'=>$request->input('name')
                   ,'email'=>$request->input('email')
                   ,'updated_at'=>\Carbon\Carbon::now()

                         ]);


                 DB::table('workers')->where('user_id',$user->id)->lockForUpdate()->update([
                    'job_id'=>$job_id
                    ,'phone'=>$request->input('phone')
                    ,'address_id'=>$address_id
                    ,'updated_at'=>\Carbon\Carbon::now()

                    ]);
                DB::commit() ;
                // {"worker":{"name":"ahmed","email":"ahmed@mail.com","id":4,"job":"Plumber" ,"phone":"01115693438","address":"test"}}

                return json_encode([
                    'worker'=>[
                    'name'=>$request->input('name')
                    ,'email'=>$request->input('email')
                    ,'id'=>$user->id
                    ,'job'=>$request->input('job')
                    ,'phone'=>$request->input('phone')
                    ,'address'=>$request->input('address')
                    ]]) ; 
            }
            else
            {

                return 'not authenticated';

            }    
        } 
        
        catch (\Exception $e) 
        {
            DB::rollBack();
            return 'worker update faild';

        }
    }


    public function user_update(Request $request)
    {
        try 
        {
            if ($user=\Auth::guard('api')->user())
            {
                 DB::beginTransaction();
                 


//{"name":"ahmed","email":"ahmed@mail.com"}


                 DB::table('users')->where('api_token',$user->api_token)->lockForUpdate()->update([
                    'name'=>$request->input('name')
                   ,'email'=>$request->input('email')
                   ,'updated_at'=>\Carbon\Carbon::now()

                         ]);


                DB::commit() ;
//{"user":{"name":"ahmed","email":"ahmed@mail.com","id":"4"}}

                return json_encode([
                    'user'=>[
                    'name'=>$request->input('name')
                    ,'email'=>$request->input('email')
                    ,'id'=>$user->id
                     ]]) ; 
            }
            else
            {

                return 'not authenticated';

            }    
        } 
        
        catch (\Exception $e) 
        {
            DB::rollBack();
            return 'update faild';

        }
    }
        public function user_retrive()
        {
            //{"user":{"id":"4","name":"ahmed","email":"ahmed@mail.com"}}

            try 
            {
                            if($user=\Auth::guard('api')->user())
                {

                return json_encode([
                    'user'=>[
                    'id'=>$user->id
                    ,'name'=>$user->name
                    ,'email'=>$user->email
                    ]]);

                }

            else
                {

                return 'not authenticated' ;
                }
    
            } 
            catch (\Exception $e) 
            {
             
             return 'user retrive error' ;   
            }
        }

        public function worker_retrive()
        {
            try 
            {

                if($user=\Auth::guard('api')->user())
                {
//{"worker":{"id":"4","name":"ahmed","email":"ahmed@mail.com","job":"Plumber","phone":"01115693438","address":"test"}}
                    $worker=DB::table('workers')->where('user_id',$user->id)->first();
                    $job=DB::table('jobs')->where('id',$worker->job_id)->value('name');
                    $address=DB::table('addresses')->where('id',$worker->address_id)->value('name');
                    return json_encode([
                        'worker'=>[
                        'id'=>$user->id
                        ,'name'=>$user->name
                        ,'email'=>$user->email
                         ,'job'=>$job
                        ,'phone'=>$worker->phone
                         ,'address'=>$address
                        ]]);

                    // return $worker->phone ;

                }
                else
                {

                    return 'worker retrive error' ;
                }
            }
             catch (\Exception $e) 
            {
                
            }
        }


}
