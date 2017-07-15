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

            else
               { 
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
                   'user'=>[ 
                    'name'=>$request->input('name')
                   ,'api_token'=>'Bearer '.$token
                    ,'id'=>$id


                    ]] ,200);
        

     }

    }


    public function worker_reg(Request $request)
    {
          


        $validation=Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone'=>'required|regex:/(01)[0-9]{9}/',
            'wage'=>'required|integer',
            'password' => 'required|min:6|max:255'
             ,'job'=>'required|exists:jobs,name'
             ,'address'=>'required|exists:addresses,name'
             ,'image'=>'file|image'
        ]);

        if ($validation->fails()) 
        {
            return response($validation->errors(),400);
        }

        // ?name=aliatef&email=aliatef@mail.com&password=password&password_confirmation=password&job=plumber&address=glaa&phone=01111111111&wage=99
                $token =str_random(60);
                $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
                $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
                if ($file=$request->file('image')) 
                {
                    $file_path=Storage::put('public/avatars',$file) ;

                }
                else 
                {
                    $file_path='public/avatars/default.jpg';
                }


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
                ,'address_id'=>$address_id
                ,'wage'=>$request->input('wage')
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()
                ,'avatar'=>$file_path
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
                    if($user->role_id==1)
                    {

                        $worker=DB::table('workers')->where('user_id',$user->id)->sharedlock()->first();
                        $job=DB::table('jobs')->where('id',$worker->job_id)->sharedlock()->value('name');
                        $address=DB::table('addresses')->where('id',$worker->address_id)->sharedlock()->value('name');

                            return  response([
                            'role_id'=>1
                            ,'api_token'=>'Bearer '.$user->api_token
                            ,'name'=>$user->name
                            ,'job'=>$job
                            ,'avatar'=>$worker->avatar
                            ,'phone'=>$worker->phone
                            ,'address'=>$address
                            ,'wage'=>$worker->wage
                            ,'id'=>$user->id
                            ],200);
                    }
                    else
                    {

                        return response([
                            'role_id'=>2
                            ,'api_token'=>'Bearer '.$user->api_token
                            ,'name'=>$user->name
                            ,'id'=>$user->id

                            ],200) ;
                    }
                }
                else 
                {

                    return response(['message'=>'wrong password'],400) ;
                }
             }
             else 
             {
                    return response(['message'=>'wrong email'],400) ;
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
        


            // ?api_token=1QjNSZyGzouE3Anyv1kQY4PJY1cAnBJKGQVZut8v9jKL2gHj3UeAInvy79aZ&job=plumber&address=glaa&name=ali&email=aliatef@mail.com&phone=01111111111&wage=59

     
            if ($user=Auth::guard('api')->user())
            {
                    $validation=Validator::make($request->all(),[

            'job'=>'required|exists:jobs,name'
            ,'address'=>'required|exists:addresses,name'
            ,'name'=>'required|max:255'
            ,'email'=>['required','max:255',Rule::unique('users')->ignore($user->id)]
            ,'phone'=>'required|regex:/(01)[0-9]{9}/|'
            ,'wage'=>'required|integer'
            ,'image'=>'file|image'


            ]);

        if ($validation->fails())
         {
           return response($validation->errors(),400);

         }   
                $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
                $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
                
                if ($file=$request->file('image')) 
                {
                    $file_path=Storage::put('public/avatars',$file) ;

                }

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
                    ,'avatar'=>$file_path
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
                    ,'avatar'=>$file_path
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
            ,'email'=>['required','max:255',Rule::unique('users')->ignore($user->id)]
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

                    return response(['message'=>'old_password wrong'],401) ;
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
                    // ,'city'=>'exists:cities,city'
                    // ,'address'=>'exists:addresses,name'
                    ,'try'=>'required|integer'
                    ]);
                if ($validation->fails())
                 {
                    return response($validation->errors(),400);
                }



                    //?api_token=6lbRlu38juCxmBp2vwD0keCsfi3o9pfTdxfI4sk0R0Ys0rdfOSTufSbxBcOa&city=mansoura&job=plumber&address=glaa

                 
               if (Auth::guard('api')->check())
                {
                       
            try 
                {
                

                $job_id=DB::table('jobs')->where([['name',$request->input('job')]])->sharedlock()->value('id');
                
                if ($request->has('address'))
                 {
                 
                $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->join('addresses','workers.address_id','=','addresses.id')->join('cities','addresses.city_id','=','cities.id')->where([['job_id',$job_id],['city',$request->input('city')],['addresses.name',$request->input('address')]])->select('users.id','users.name','workers.avatar','workers.phone','workers.wage','workers.rate','cities.city','addresses.name as address')->sharedlock()->skip(($request->input('try')-1)*5)->take(5)->get();
                                }                
                elseif ($request->has('city') &! $request->has('address')) 
                {
                 $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->join('addresses','workers.address_id','=','addresses.id')->join('cities','addresses.city_id','=','cities.id')->where([['job_id',$job_id],[
                    'city',$request->input('city')]])->select('users.id','users.name','workers.avatar','workers.phone','workers.wage','workers.rate','cities.city','addresses.name as address')->sharedlock()->skip(($request->input('try')-1)*5)->take(5)->get();

                }
                 else 
                 {
                 $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->join('addresses','workers.address_id','=','addresses.id')->join('cities','addresses.city_id','=','cities.id')->where([['job_id',$job_id]])->select('users.id','users.name','workers.avatar','workers.phone','workers.wage','workers.rate','cities.city','addresses.name as address')->sharedlock()->skip(($request->input('try')-1)*5)->take(10)->get();   
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

            public function rate(Request $request)

            //?api_token=iOCjTw3HE6pDtXI4BQcmAP8T2r7NsWleJT0SBNTyC3vt37FQM4zxvJwxz3zn&worker_id=166&rating=5
            {
                $validation=Validator::make($request->all(),[
                    'worker_id'=>'required|integer|exists:users,id'
                    ,'rating'=>'required|integer|min:1|max:5'
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
                        DB::table('ratings')->where([['worker_id',$request->input('worker_id')],['user_id',$user->id]])->update(['rating'=>$request->input('rating')]);
                        $rate=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->avg('rating');
                        DB::table('workers')->where([['user_id',$request->input('worker_id')]])->update(['rate'=>$rate]);

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
                    DB::table('ratings')->insert(['worker_id'=>$request->input('worker_id'),'user_id'=>$user->id,'rating'=>$request->input('rating')]);
                    $rate=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->avg('rating');
                    DB::table('workers')->where([['user_id',$request->input('worker_id')]])->update(['rate'=>$rate]);
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





public function category(Request $request)
        {  



            //?api_token=Elwo2nH1xIj9oDC0ppOTOoI5QDxsxc8STmk9jQ3XsBslKGb8MediS2Aj7kRg&job=plumber
                

                $validation=Validator::make($request->all(),[
                  'job'=>'required|exists:jobs,name'
                  ,'city'=>'exists:cities,city'
                  ,'address'=>'exists:addresses,name'
                    // ,'try'=>'required|integer'
                    ]);
                if ($validation->fails()) 
                {
                    return response($validation->errors(),200);
                }


                else
                {

                if (Auth::guard('api')->check()) 

                {
                      $job_id=DB::table('jobs')->where([['name',$request->input('job')]])->sharedlock()->value('id');
          
            try 
            {
                if ($request->hasInput('address'))
                 {
                    
           $result=DB::table('workers')->join('users','workers.user_id','=','users.id')->where([['job_id',$job_id],['address_id',$address_id],'city_id',])->select(['id','name','avatar','phone','wage','rate'])->sharedlock()->skip(0)->take(10)->get();
                }
                elseif ($request->hasInput('city') && !$request->hasInput('address')) 
                {
                    
            $result=DB::table('users')->select(['id','name','avatar','phone','wage','rate','address_id'])->join('workers','users.id','=','workers.user_id')->where([['job_id',$job_id]])->get();
                }
    
            } catch (QueryException $e) 
            {
                return response(['message'=>'server error'],500);
                
            }
                
            return response($result,200);              

                }
                else 
                {
                    return response(['message'=>'not authenticated'],404);
                }
            

             

            }
}            




    public function delete(Request $request)
    {   
        // ?api_token=EqXtrJyBnZ0IL0Yx9sSYBQffiwn9i2fSDFKAOtABNULq8ly65oWarI4vHw7U&password=password&password_confirmation=password
        
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
                    return response(['message'=>'wrong password'],401);
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






public function test(Request $request)
{   
    
}


}