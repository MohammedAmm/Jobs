<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\database\QueryException;
use Illuminate\Support\Facades\Mail;
use App\Mail\HERFA;
use Carbon\Carbon;
use DB;
use Validator ;
use Illuminate\Validation\Rule;
class ApiController extends Controller
{
     public function user_reg(Request $request)
    {
    	


     // ?name=ali&email=ali@gmail.com&password=password&password_confirmation=password
        

           $validation=Validator::make($request->all(),[
            
            'name'=>'required|max:255'
            ,'email'=>'required|email|unique:users,email|max:255'
            ,'password'=>'required|max:255|min:6|confirmed'
            ]);

            if ($validation->fails()) 

            {
                
                return response($validation->errors(),400);

            }

             
            $token =str_random(60);
        
        try {
            
            DB::beginTransaction();     
           $id=DB::table('users')->insertGetId(

        [
                'api_token'=>$token
                ,'name' => $request->input('name')
                ,'email' => $request->input('email')
                ,'role_id' => 2
                ,'verified'=>1
                ,'password' => bcrypt($request->input('password'))
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()

            ]);
                DB::commit();
                
    
                }

         catch (QueryException $ex) {
            DB::rollBack();
            
            return response(['message'=>'server error'],500) ;            
        }

         Mail::to($request->input('email'))->send(new HERFA('emails.apiconfirmation','HERFA'));


                 
                 return response( [
                    
                    'name'=>$request->input('name')
                   ,'api_token'=>'Bearer '.$token
                    ,'id'=>$id


                    ] ,200);
        

     

    }


    public function worker_reg(Request $request)
    {
          


        $validation=Validator::make($request->all(), [
              'name' => 'required|max:255'
             ,'email' => 'required|email|max:255|unique:users,email'
             ,'age'=>'required|integer|min:18|max:90'
             ,'phone'=>'required|regex:/(01)[0-9]{9}/'
             ,'wage'=>'required|integer'
             ,'password' => 'required|min:6|max:255|confirmed'
             ,'job'=>'required|exists:jobs,name'
             ,'city'=>'required|exists:cities,city'
             ,'address'=>'required|exists:addresses,name'
             
        ]);

        if ($validation->fails()) 
        {
            return response($validation->errors(),400);
        }

        // ?name=ahmedsalem&email=ahmedsalem@mail.com&age=40&password=password&password_confirmation=password&job=painter&city=mansoura&address=glaa&phone=01111111111&wage=99
                $token =str_random(60);
                $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
                $city_id=DB::table('cities')->where([['city',$request->input('city')]])->sharedlock()->value('id');
                $address_id=DB::table('addresses')->where([['name',$request->input('address')],['city_id',$city_id]])->sharedlock()->value('id');
                
            try 
            {
                      
             
                                    
                DB::beginTransaction();
                $id=DB::table('users')->insertGetId(

        [
                'api_token'=>$token
                ,'name' => $request->input('name')
                ,'email' => $request->input('email')
                ,'role_id' => 1
                ,'verified'=>1
                ,'password' => bcrypt($request->input('password'))
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()

            ]);


             
          

            DB::table('workers')->insert(

                [
       

                'user_id'=>$id
                ,'job_id'=>$job_id
                ,'phone'=>$request->input('phone')
                ,'age'=>$request->input('age')
                ,'address_id'=>$address_id
                ,'wage'=>$request->input('wage')
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
               
                ]);




           DB::commit();
            
           } 


            catch (QueryException $e) 

            {
                DB::rollBack();
                return response(['message'=>'server error'],500) ;
            }

            Mail::to($request->input('email'))->send(new HERFA('emails.apiconfirmation','HERFA'));

                 return response([
                    'worker'=>[
                    'name'=>$request->input('name')
                    ,'api_token'=>'Bearer '.$token
                    ,'id'=>$id
                    ,'phone'=>$request->input('phone')
                    ,'age'=>$request->input('age')
                    ,'wage'=>$request->input('wage')
                    ,'avatar'=>'/public/avatars/default.jpg'
                    ,'address'=>$request->input('address')
                    ,'city'=>$request->input('city')
                    ]],200);

    }




     public function login(Request $request)
    {

        $validation=Validator::make($request->all(),[

            'email'=>'required|email|exists:users,email|max:255'
            ,'password'=>'required|min:6|max:255'
    ]);
        if ($validation->fails()) 
        {
            return response ($validation->errors(),400);


        }


        try 
        {
             if($user=DB::table('users')->where('email',$request->input('email'))->sharedlock()->first())
             {

                if (Hash::check($request->input('password'),$user->password)) 
                { 
                    $token=str_random(60);
                    if($user->role_id==1)
                    {

                        $worker=DB::table('workers')->where('user_id',$user->id)->sharedlock()->first();
                        $job=DB::table('jobs')->where('id',$worker->job_id)->sharedlock()->value('name');
                        $address=DB::table('addresses')->where('id',$worker->address_id)->sharedlock()->value('name');
                        $city=DB::table('addresses')->join('cities','addresses.city_id','=','cities.id')->where([['addresses.id',$worker->address_id]])->value('city');
                        
                        DB::table('users')->where([['id',$user->id]])->lockForUpdate()->update(['api_token'=>$token]);

                           return  response([
                            'role_id'=>1
                            ,'api_token'=>'Bearer '.$token
                            ,'name'=>$user->name
                            ,'job'=>$job
                            ,'avatar'=>$worker->avatar
                            ,'phone'=>$worker->phone
                            ,'city'=>$city
                            ,'address'=>$address
                            ,'wage'=>$worker->wage
                            ,'age'=>$worker->age
                            ,'id'=>$user->id
                            ],200);
                            
                    }
                    else
                    {

                   DB::table('users')->where([['id',$user->id]])->lockForUpdate()->update(['api_token'=>$token]);

                        return response([
                            'role_id'=>2
                            ,'api_token'=>'Bearer '.$token
                            ,'name'=>$user->name
                            ,'id'=>$user->id
                            ,DB::table('ratings')->where([['user_id',$user->id]])->select('worker_id','rating')->get()

                            ],200) ;
                    }
                }
                else 
                {

                    return response(['message'=>'wrong password'],404) ;
                }
             }
             else 
             {
                    return response(['message'=>'wrong email'],404) ;
             }
        }
         catch (QueryException $e) 

        {
             return response(['message'=>'server error'],500) ;
        }
    }

    public function get(Request $request)
    {
        
            try 
            {
                $addresses=DB::table('addresses')->join('cities','addresses.city_id','=','cities.id')->select('city','name')->get();
                $jobs=DB::table('jobs')->select('name')->get();

                       
           } 
         catch (QueryException $e)
           {
                return response(['message'=>'server error '],500) ;         
            }

                return response(['addresses'=>$addresses,'jobs'=>$jobs],200);     


           
    }


    public function worker_update(Request $request)
    {
        


            // ?api_token=J4CDKMZb1kWkMszhcJBCAic3niEX8LIHKUnKOOwohB072YmH3x1lggbHBM9O&job=plumber&address=glaa&name=ahmedsalem70&email=ahmedsalem70@mail.com&phone=01111111111&wage=59&age=44&city=mansoura

     
            if ($user=Auth::guard('api')->user())
            {
                    $validation=Validator::make($request->all(),[

            'job'=>'required|exists:jobs,name'
            ,'address'=>'required|exists:addresses,name'
            ,'name'=>'required|max:255'
            ,'email'=>['required','max:255',Rule::unique('users')->ignore($user->id)]
            ,'phone'=>'required|regex:/(01)[0-9]{9}/|'
            ,'wage'=>'required|integer'
            ,'age'=>'required|integer|min:18|max:90'
            ,'city'=>'required|exists:cities,city'

            ]);

        if ($validation->fails())
         {
           return response($validation->errors(),400);

         }   
                $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');   
                $city_id=DB::table('cities')->where([['city',$request->input('city')]])->value('id'); 
                $address_id=DB::table('addresses')->where([['name',$request->input('address')],['city_id',$city_id]])->sharedlock()->value('id');
                
              

            try {
                 DB::beginTransaction();
                    


                 DB::table('users')->where('id',$user->id)->lockForUpdate()->update([
                    'name'=>$request->input('name')
                   ,'email'=>$request->input('email')
                   ,'updated_at'=>Carbon::now()

                         ]);


                 DB::table('workers')->where('user_id',$user->id)->lockForUpdate()->update([
                    'job_id'=>$job_id
                    ,'phone'=>$request->input('phone')
                    ,'wage'=>$request->input('wage')
                    ,'age'=>$request->input('age')
                    ,'address_id'=>$address_id
                    ,'updated_at'=>Carbon::now()
                    
                    ]);

                DB::commit() ;
             }
                catch (QueryException $e) 
            {
            DB::rollBack();
           return response(['message'=>'server error'],500) ;
            }
         }
            else
            {

                    return response(['message'=>'not authenticated'],404) ;

            }    
  
            return response([
                    'worker'=>[
                    'name'=>$request->input('name')
                    ,'email'=>$request->input('email')
                    ,'id'=>$user->id
                    ,'age'=>$request->input('age')
                    ,'job'=>$request->input('job')
                    ,'phone'=>$request->input('phone')
                    ,'address'=>$request->input('address')
                    ,'wage'=>$request->input('wage')
                    ]],200) ;
    
           }  

                          
        
       
    


    public function user_update(Request $request)
    {
       
        



// ?api_token=E7H1zyvUDpu0P1L8c70Jis0VWwIRcGthihxIMlsPbC4YtHHlEAGZr48pM3y1&name=malina&email=hamadaraya@mail.com

        
            if ($user=Auth::guard('api')->user())
            {
                 
            $validation=Validator::make($request->all(),[
            'name'=>'required|max:255'
            ,'email'=>['required','max:255',Rule::unique('users')->ignore($user->id),'email']
            ]);



        if ($validation->fails())
         {
            return response($validation->errors(),400);
         }



                try 
        {

                 DB::beginTransaction();
                 




                 DB::table('users')->where('api_token',$user->api_token)->lockForUpdate()->update([
                    'name'=>$request->input('name')
                   ,'email'=>$request->input('email')
                   ,'updated_at'=>Carbon::now()

                         ]);


                DB::commit() ;
                } 
        
        catch (QueryException $e) 
        {
            DB::rollBack();
             return response(['message'=>'server error'],500) ;

        }
             
                return response([
                    'user'=>[
                    'name'=>$request->input('name')
                    ,'email'=>$request->input('email')
                    ,'id'=>$user->id
                     ]],200) ; 
            }
            else
            {

                    return response(['message'=>'not authenticated'],404) ;

            }    
        
    }

        public function password_reset(Request $request)
        {
            
            //?api_token=POj9p3nzcRprHZmwsKH3xurUTaGA9TIOExZFeNPlxjeeJCAUQ5gTSiMHhuE1&old_password=password&password=password&password_confirmation=password



            $validation=Validator::make($request->all(),[

                'old_password'=>'required|min:6|max:255'
                ,'password'=>'required|confirmed|min:6|max:255'
                ]);


            if ($validation->fails()) 
            {
               return response($validation->errors(),400);
            }



            
              if($user=Auth::guard('api')->user())
              {
                if (Hash::check($request->input('old_password'),$user->password))
                    
                 {
                    try 
                    {
                      DB::table('users')->where('id',$user->id)->lockForUpdate()->update(['password'=>bcrypt($request->input('password')),

                        'updated_at'=>Carbon::now()

                        ]);       
                      }
                       catch (QueryException $e) 
                       {
                    return response(['message'=>'server error'],500) ;
                          
                      }  
                    return response(['message'=>'password updated successfully'],200); 
                 }
                else
                {

                    return response(['message'=>'old_password wrong'],404) ;
                }      


              }
              else 
              {

                    return response(['message'=>'not authenticated'],404) ;
              }  
        }

           

            public function search(Request $request)
            {
    
                    $validation=Validator::make($request->all(),[

                    'job'=>'required|exists:jobs,name'
                     ,'city'=>'nullable|exists:cities,city'
                    ,'address'=>'nullable|exists:addresses,name'
                    ,'try'=>'required|integer'
                    ]);
                if ($validation->fails())
                 {
                    return response($validation->errors(),400);
                }



                    //?api_token=iOCjTw3HE6pDtXI4BQcmAP8T2r7NsWleJT0SBNTyC3vt37FQM4zxvJwxz3zn&city=mansoura&job=electrician&address=glaa&try=1

                 
               if ($user=Auth::guard('api')->user())
                {
                       
            try 
                {
                
                
                $job_id=DB::table('jobs')->where([['name',$request->input('job')]])->sharedlock()->value('id');
                
                if ($request->has('address'))
                 {
                 
                $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->join('addresses','workers.address_id','=','addresses.id')->join('cities','addresses.city_id','=','cities.id')->where([['job_id',$job_id],['city',$request->input('city')],['addresses.name',$request->input('address')]])->select('users.id','users.name','workers.avatar','workers.phone','workers.wage','workers.age','workers.rate','workers.no_rates','cities.city','addresses.name as address')->sharedlock()->skip(($request->input('try')-1)*10)->take(10)->get();
                 
                                }
                
                elseif ($request->has('city') &! $request->has('address')) 
                {
                 $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->join('addresses','workers.address_id','=','addresses.id')->join('cities','addresses.city_id','=','cities.id')->where([['job_id',$job_id],[
                    'city',$request->input('city')]])->select('users.id','users.name','workers.avatar','workers.phone','workers.wage','workers.age','workers.rate','workers.no_rates','cities.city','addresses.name as address')->sharedlock()->skip(($request->input('try')-1)*10)->take(10)->get();

                }
                 else 
                 {
                 $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->join('addresses','workers.address_id','=','addresses.id')->join('cities','addresses.city_id','=','cities.id')->where([['job_id',$job_id]])->select('users.id','users.name','workers.avatar','workers.phone','workers.wage','workers.age','workers.rate','workers.no_rates','cities.city','addresses.name as address')->sharedlock()->skip(($request->input('try')-1)*10)->take(10)->get();   
                 }       


                 
                } 
                catch (QueryException $e) {
                return response(['message'=>'server error'],500) ;      
                }
                
                 return  response($result,200);

               }

               else 
               {

                return response(['message'=>'not authenticated'],404) ;
               }
   
                 
            }

            public function getc(Request $request)
                {
                    

                    if ($user=Auth::guard('api')->user())
                     
                    {
                        $validation=Validator::make($request->all(),[
                            'worker_id'=>'required|integer'
                            ]);
                        if ($validation->fails()) 
                        {
                            return response($validation->errors(),400);
                        }


                        try 
                        {
                            $result=DB::table('ratings')->where([['user_id',$user->id],['worker_id',$request->input('worker_id')]])->select('user_id','rating','comment');
                            $final=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->select('user_id','rating','comment')->union($result)->get();

                        } 
                        catch (QueryException $e)
                         {
                           return response(['message'=>'server error'],500); 
                        }

                        return response($final,200);




                    }
                    else
                    {
                        return response(['message'=>'not authenticated'],404);

                    }





                }


            public function rate(Request $request)

            //?api_token=iOCjTw3HE6pDtXI4BQcmAP8T2r7NsWleJT0SBNTyC3vt37FQM4zxvJwxz3zn&worker_id=166&rating=5
            {
                $validation=Validator::make($request->all(),[
                    'worker_id'=>'required|integer|exists:users,id'
                    ,'rating'=>'required|integer|min:1|max:5'
                    ,'comment'=>'nullable|alpha_dash'
                    ]);
                if ($validation->fails())
                 {
                   return response($validation->errors(),400);
                }





                                 if($user=Auth::guard('api')->user())

                {
                    if (DB::table('ratings')->where([['worker_id',$request->input('worker_id')],['user_id',$user->id]])->first()) 
                    {
                     
                        #update the existing record 
                        try 
                        {
                         
                        DB::beginTransaction();
                        DB::table('ratings')->where([['worker_id',$request->input('worker_id')],['user_id',$user->id]])->update(['rating'=>$request->input('rating'),'created_at'=>Carbon::now()]);
                        $rate=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->avg('rating');
                        DB::table('workers')->where([['user_id',$request->input('worker_id')]])->update(['rate'=>$rate]);
                        DB::table('workers')->where([['user_id',$request->input('worker_id')]])->increment('no_rates');

                        DB::commit();   
                        } 
                        catch (QueryException $e)
                         {
                            DB::rollBack();
                            return response(['message'=>'server error'],500);  
                        }



                    }

                    else
                    {

                    try 
                    {
                    DB::beginTransaction(); 
                    DB::table('ratings')->insert(['worker_id'=>$request->input('worker_id'),'user_id'=>$user->id,'rating'=>$request->input('rating'),'created_at'=>Carbon::now()]);
                    $rate=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->avg('rating');
                    DB::table('workers')->where([['user_id',$request->input('worker_id')]])->update(['rate'=>$rate]);
                    DB::table('workers')->where([['user_id',$request->input('worker_id')]])->increment('no_rates');
                    DB::commit();
    
                    }
                     catch (QueryException $e)
                      {  
                            DB::rollBack();
                           return response(['message'=>'server error'],500);  
                       
                    }
                    

                    }

                        return response(['message'=>'successfully rated '],200);

                }
                else 
                {

                return response(['message'=>'not authenticated'],404);  

                }


            
                   
                } 









    public function delete(Request $request)
    {   
        // ?api_token=ZNjIgso2puGCdOQDlmqIkmyY2uO4Y0ezIKsWiFJTAXRr198rOsPiqTS40Lwh&password=password&password_confirmation=password
        
        $validation=Validator::make($request->all(),[
            'password'=>'required|min:6|max:255|confirmed'
            ]);
        if ($validation->fails()) 
        {
           return response($validation->errors(),400);
        }

         if ($user=Auth::guard('api')->user())
        {   
            if (Hash::check($request->input('password'),$user->password))
             {
                try
                 {
                    DB::beginTransaction();
                    DB::table('users')->where([['id',$user->id]])->lockForUpdate()->delete();
                    DB::commit();   
                }
                 catch (QueryException $e) 
                {
                    DB::rollBack();
                  return  response(['message'=>'server error'],500);
                    
                }

                return response(['message'=>'good bye'],200);
    
            }
            else 
                {
                    return response(['message'=>'wrong password'],404);
                }

          } 
        else 
        {
            return response(['message'=>'not authenticated'],404);


         }   
        
        
    }


public function forget_first(Request $request)
{

    //?email=ahmedmido@mail.com
    $validation=Validator::make($request->all(),[
        'email'=>'required|email|exists:users,email'
        ]);
    if ($validation->fails()) 
    {
       return response($validation->errors(),400);
    }
    else 
    {
         $token=str_random(6);
    
    try 
    {
        DB::beginTransaction();   
        DB::table('password_resets')->where([['email',$request->input('email')]])->delete();
        DB::table('password_resets')->insert(['email'=>$request->input('email'),'token'=>$token,'created_at'=>Carbon::now()]);
        DB::commit();
    } 
    catch (QueryException $e)
     {
        DB::rollBack();
        return response(['message'=>'server error'],500);
    }

    Mail::to($request->input('email'))->send(new HERFA('emails.forgetPassword','HERFA',$token));
    return response(['message'=>'Token has been sent to your email '],200);
 }
}




public function forget_second(Request $request)
{
    $validation=Validator::make($request->all(),[
        'token'=>'required|min:6|max:6|exists:password_resets,token'
        ,'password'=>'required|min:6|max:255|confirmed'
        ]);
    if ($validation->fails())
     {
        
        return response($validation->errors(),400);


    }
    else
    {
        $email=DB::table('password_resets')->where([['token',$request->input('token')]])->value('email');
        try 
        {
            DB::beginTransaction();
            DB::table('users')->where([['email',$email]])->update(['password'=>bcrypt($request->input('password'))]);
            DB::table('password_resets')->where([['email',$email]])->delete();
            DB::commit();   
        }
         catch (QueryException $e)
          {
            DB::rollBack();
            return response(['message'=>'server error'],500);
        }

            return response(['message'=>'password has been reassigned ,now u can login'],200);    
    }



}

public function profile_update( Request $request)
{
    
    if ($user=Auth::guard('api')->user())

    {
        
         if ($user->role_id==1) 
         {
         
                   $validation=Validator::make($request->all(),[
                    'image'=>'required|file|image'
                    
                    ]);
     
        if ($validation->fails())
         {
          return response($validation->errors(),400);
        }

        
           if ($file=$request->file('image')) 
                {
                    $file_path=Storage::put('public/avatars',$file) ;
                    $old=DB::table('workers')->where([['user_id',$user->id]])->value('avatar');
                }
                else 
                {
                    $file_path='public/avatars/default.jpg';
                }    

                try 
                {
                            DB::beginTransaction();
                            DB::table('workers')->where([['user_id',$user->id]])->lockForUpdate()->update(['avatar'=>$file_path,'updated_at'=>Carbon::now()]);


                            DB::commit();
                } 
                catch (QueryException $e)

                {
                    DB::rollBack();
                    return response(['message'=>'server error'],500);    
                }

                  if ($old!='public/avatars/default.jpg')
                   {
                         Storage::delete($old) ; 
                    }  
           return response(['message'=>'profile updated successfully'],200);
           } 
        
    
            



         }
         else 
         {
            return response(['message'=>'not authenticated'],404);
         }



    }


    




public function test(Request $request)
{  
        // Storage::delete('public/avatars/vGwO3yl6sfMRG5noViJ1s3DSwtNfK6iPO7qgCqvv.jpeg');
}


}

<<<<<<< HEAD
=======
//1575118
//80011012
>>>>>>> a128f482a56e889667b89f993695ebdb7a3c2c29
