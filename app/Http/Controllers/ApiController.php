<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Exception;
use Illuminate\Support\Facades\Mail;
use App\Mail\HERFA;
use Carbon\Carbon;
use DB;
use Validator ;
class ApiController extends Controller
{
     public function user_reg(Request $request)
    {
    	


        

            // $validation=Validator::make($request->all(),[
            
            // 'name'=>'required|alpha_dash|max:255'
            // ,'email'=>'required|email|unique:users,email|max:255'
            // ,'password'=>'required|max:255|min:6|confirmed'
            // ]);

            // if ($validation->fails()) 

            // {
                
            //     return response($validation->errors(),400);

            // }


     // ?name=ali&email=ali&password=12
        
        try {
            
            $token =str_random(60);

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

                Mail::to($request->input('email'))->send(new HERFA('emails.apiconfirmation','HERFA'));


                 
                 return response([
                    'user'=>[
                    'name'=>$request->input('name')
                    ,'api_token'=>'Bearer '.$token
                    ,'id'=>$id


                    ]],200) ;
        

    
                }

         catch (Exception $ex) {
            
            return response(['message'=>'server fault'],500) ;            
        }


    }


    public function worker_reg(Request $request)
    {
          


        // $validation=Validator::make($request->all(), [
        //     'name' => 'required|max:255',
        //     'email' => 'required|email|max:255|unique:users,email',
        //     'phone'=>'required|regex:/(01)[0-9]{9}/|unique:workers',
        //     'wage'=>'required|integer',
        //     'password' => 'required|min:6|max:255'
        //      ,'job'=>'required|exists:jobs,name'
        //      ,'address'=>'required|exists:addresses,name'
        // ]);

        // if ($validation->fails()) 
        // {
        //     return response($validation->errors(),445)
        // }


        // ?name=aliatef&email=aliatef@mail.com&password=password&password_confirmatoin=password&job=plumber&address=glaa&phone=01111111111&wage=99

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
                ,'verified'=>1
                ,'password' => bcrypt($request->input('password'))
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()

            ]);


             $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
             $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
          

            DB::table('workers')->insert(

                [
       

                'user_id'=>$id
                ,'job_id'=>$job_id
                ,'phone'=>$request->input('phone')
                ,'address_id'=>$address_id
                ,'wage'=>$request->input('wage')
                ,'created_at'=>Carbon::now()
                ,'updated_at'=>Carbon::now()

                ]);




           DB::commit();
           Mail::to($request->input('email'))->send(new HERFA('emails.apiconfirmation','HERFA'));
            
         


                 return response([
                    'worker'=>[
                    'name'=>$request->input('name')
                    ,'api_token'=>'Bearer '.$token
                    ,'id'=>$id

                    ]],200);


            } 


            catch (Exception $e) 

            {
                DB::rollBack();
                return 'worker registeration error' ;
            }
    }




     public function login(Request $request)
    {

    //     $validation=Validator::make($request->all(),[

    //         'email'=>'required|email|exists:users,email|max:255'
    //         ,'password'=>'required|min:6|max:255'
    // ]);
    //     if ($validation->fails()) 
    //     {
    //         return response ($validation->errors(),446);


    //     }

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
                        $result=[
                            'role_id'=>1
                            ,'api_token'=>'Bearer '.$user->api_token
                            ,'name'=>$user->name
                            ,'job'=>$job
                            ,'avatar'=>$worker->avatar
                            ,'phone'=>$worker->phone
                            ,'address'=>$address
                            ,'wage'=>$worker->wage
                            ,'id'=>$user->id
                            ];

                            return  response($result,200);
                    }
                    else
                    {
                        $result=[
                            'role_id'=>2
                            ,'api_token'=>'Bearer '.$user->api_token
                            ,'name'=>$user->name
                            ,'id'=>$user->id

                            ];

                        return response($result,200) ;
                            


                    }



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
         catch (Exception $e) 

        {
            return 'login error' ;
        }
    }


    public function worker_update(Request $request)
    {
        // $validation=Validator::make($request->all(),[

        //     'job'=>'required|exists:jobs,name'
        //     ,'address'=>'required|exists:addresses,name'
        //     ,'name'=>'required|max:255'
        //     ,'email'=>'required|unique:users,email'
        //     ,'phone'=>'required|regex:/(01)[0-9]{9}/|'
        //     ,'wage'=>'required|integer'

        //     ]);

        // if ($validation->fails())
        //  {
        //    return response($validation->errors(),446);

        //  }

            // ?api_token=1QjNSZyGzouE3Anyv1kQY4PJY1cAnBJKGQVZut8v9jKL2gHj3UeAInvy79aZ&job=plumber&address=glaa&name=ali&email=aliatef@mail.com&phone=01111111111&wage=59

     try 
        {
            if ($user=Auth::guard('api')->user())
            {
                $job_id=DB::table('jobs')->where('name',$request->input('job'))->sharedlock()->value('id');    
                $address_id=DB::table('addresses')->where('name',$request->input('address'))->sharedlock()->value('id');
                 DB::beginTransaction();
                    


                 DB::table('users')->where('api_token',$user->api_token)->lockForUpdate()->update([
                    'name'=>$request->input('name')
                   ,'email'=>$request->input('email')
                   ,'updated_at'=>Carbon::now()

                         ]);


                 DB::table('workers')->where('user_id',$user->id)->lockForUpdate()->update([
                    'job_id'=>$job_id
                    ,'phone'=>$request->input('phone')
                    ,'wage'=>$request->input('wage')
                    ,'address_id'=>$address_id
                    ,'updated_at'=>Carbon::now()

                    ]);
                DB::commit() ;

                return response(json_encode([
                    'worker'=>[
                    'name'=>$request->input('name')
                    ,'email'=>$request->input('email')
                    ,'id'=>$user->id
                    ,'job'=>$request->input('job')
                    ,'phone'=>$request->input('phone')
                    ,'address'=>$request->input('address')
                    ,'wage'=>$request->input('wage')
                    ]]),200) ; 
            }
            else
            {

                return 'not authenticated';

            }    
        } 
        
        catch (Exception $e) 
        {
            DB::rollBack();
            return 'worker update faild';

        }
    }


    public function user_update(Request $request)
    {
       
        // $validation=Validator::make($request->all(),[
        //     'name'=>'required|max:255'
        //     ,'email'=>'required|email|unique:users,email'
        //     ]);



        // if ($validation->fails())
        //  {
        //     return response($validation->errors(),447);
        //  }




// ?api_token=Elwo2nH1xIj9oDC0ppOTOoI5QDxsxc8STmk9jQ3XsBslKGb8MediS2Aj7kRg&name=hamadaraya&email=hamadaraya@mail.com

        try 
        {
            if ($user=Auth::guard('api')->user())
            {
                 DB::beginTransaction();
                 




                 DB::table('users')->where('api_token',$user->api_token)->lockForUpdate()->update([
                    'name'=>$request->input('name')
                   ,'email'=>$request->input('email')
                   ,'updated_at'=>Carbon::now()

                         ]);


                DB::commit() ;

                return response(json_encode([
                    'user'=>[
                    'name'=>$request->input('name')
                    ,'email'=>$request->input('email')
                    ,'id'=>$user->id
                     ]]),200) ; 
            }
            else
            {

                return 'not authenticated';

            }    
        } 
        
        catch (Exception $e) 
        {
            DB::rollBack();
            return 'update faild';

        }
    }
//         public function user_retrieve()
//         {
//             //{"user":{"id":"4","name":"ahmed","email":"ahmed@mail.com"}}

//             try 
//             {
//                             if($user=Auth::guard('api')->user())
//                 {

//                 return json_encode([
//                     'user'=>[
//                     'id'=>$user->id
//                     ,'name'=>$user->name
//                     ,'email'=>$user->email
//                     ]]);

//                 }

//             else
//                 {

//                 return 'not authenticated' ;
//                 }
    
//             } 
//             catch (Exception $e) 
//             {
             
//              return 'user retrive error' ;   
//             }
//         }

//         public function worker_retrieve()
//         {
//             try 
//             {

//                 if($user=Auth::guard('api')->user())
//                 {
// //{"worker":{"id":"4","name":"ahmed","email":"ahmed@mail.com","job":"Plumber","phone":"01115693438","address":"test"}}
//                     $worker=DB::table('workers')->where('user_id',$user->id)->sharedlock()->first();
//                     $job=DB::table('jobs')->where('id',$worker->job_id)->sharedlock()->value('name');
//                     $address=DB::table('addresses')->where('id',$worker->address_id)->sharedlock()->value('name');
//                     return json_encode([
//                         'worker'=>[
//                         'id'=>$user->id
//                         ,'name'=>$user->name
//                         ,'email'=>$user->email
//                          ,'job'=>$job
//                         ,'phone'=>$worker->phone
//                          ,'address'=>$address
//                         ]]);

//                     // return $worker->phone ;

//                 }
//                 else
//                 {

//                     return 'worker retrive error' ;
//                 }
//             }
//              catch (Exception $e) 
//             {
                
//             }
//         }

        public function password_reset(Request $request)
        {
            
            // $validation=Validator::make($request,[

            //     'old_password'=>'required|min:6|max:255'
            //     ,'password'=>'required|confirmed|min:6|max:255'
            //     ]);


            // if ($validation->fails()) 
            // {
            //    return response($validation->errors(),448);
            // }



            try 
            {
              if($user=Auth::guard('api')->user())
              {
                if (Hash::check($request->input('old_password'),$user->password))
                    
                 {
                    DB::table('users')->where('id',$user->id)->lockForUpdate()->update(['password'=>bcrypt($request->input('password')),

                        'updated_at'=>Carbon::now()

                        ]);     
                    return response('password updated successfully',200); 
                 }
                else
                {

                    return 'old password wrong' ;
                }       


              }
              else 
              {

                return 'not authenticated';
              }  
            }
            catch (Exception $e) 
            {
                
            }
        }

            public function search(Request $request)
            {
                // $validation=Validator::make($request->all(),[

                //     'job'=>'required|exists:jobs,name'
                //     ,'city'=>'required|exists:cities,city'
                //     ,'address'=>'required|exists:addresses,name'
                //     ]);
                // if ($validation->fails())
                //  {
                //     return response($validation->errors(),450);
                // }





                try 
                {
                 
               if (Auth::guard('api')->check())
                {
                       



                $job_id=DB::table('jobs')->where([['name',$request->input('job')]])->sharedlock()->value('id');
                $city_id=DB::table('cities')->where([['city',$request->input('city')]])->value('id');
                $address_id=DB::table('addresses')->where([['name',$request->input('address')],['city_id',$city_id]])->sharedlock()->value('id');



                 return json_encode(DB::table('workers')->where([['job_id',$job_id],['address_id',$address_id]])->sharedlock()->skip($request->input('try')*10)->take(10));



               }

               else 
               {

                return 'Not authenticated' ;
               }
   
                } catch (Exception $e) {
                return 'something went wrong' ;      
                }
            }

            public function rate(Request $request)
            {
                // $validation=Validator::make($request->all(),[
                //     'worker_id'=>'required|integer|exists:users,id'
                //     ,'rating'=>'required|integer|min:1|max:5'
                //     ]);
                // if ($validation->fails())
                //  {
                //    return response($validation->errors(),449);
                // }






                try 
                {
                                 if($user=Auth::guard('api')->user())

                {
                    if (DB::table('ratings')->where([['worker_id',$request->input('worker_id')],['user_id',$user->id]])) 
                    {
                     
                        #update the existing record 

                        DB::beginTransaction();
                        DB::table('ratings')->where([['worker_id',$request->input('worker_id')],['user_id',$user->id]])->update(['rating'=>$request->input('rating')]);
                        $rate=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->avg('rating');
                        DB::table('workers')->where([['user_id',$request->input('workder_id')]])->update(['rate'=>$rate]);

                        DB::commit();
                        return 'rate success' ;



                    }

                    else
                    {

                    DB::beginTransaction(); 
                    DB::table('ratings')->insert(['worker_id'=>$request->input('worker_id'),'user_id'=>$user->id,'rating'=>$request->input('rating')]);
                    $rate=DB::table('ratings')->where([['worker_id',$request->input('worker_id')]])->avg('rating');
                    DB::table('workers')->where([['user_id',$request->input('workder_id')]])->update(['rate'=>$rate]);
                    DB::commit();

                    return 'rate success' ;

                    }



                }
                else 
                {

                    return 'not authenticated';
                }


            }
                    catch (Exception $e) 
                {
                    DB::rollBack();
                return 'something wrong' ;    
                }

                } 




                public function profileUp(Request $request)
                {





                    try 
                    {
                        if ($user=Auth::guard('api')->user()) 
                        {
                                 
                    if ($file=$request->file('image'))
                     {
                        if ($request->file('image')->isValid())
                        {
                         
                         $file=Storage::put('avatars',$file) ;

                         
                         
                        return redirect('uploads/'.$file)  ;



                     }

                        }
                }                      
                       else 
                       {
                        return 'not authenticated' ;
                       } 
                               
                    } 
                    catch (Exception $e) 
                    {
                        return 'error' ;    
                    }
                
            }



public function category(Request $request)
        {  



            //?api_token=Elwo2nH1xIj9oDC0ppOTOoI5QDxsxc8STmk9jQ3XsBslKGb8MediS2Aj7kRg&job=plumber
                

                // $validation=Validator::make($request->all(),[
                //     'job'=>'required|exists:jobs,name'
                //     ,'try'=>'required|integer'
                //     ]);
                // if ($validation->fails()) 
                // {
                //     return response($validation->errors(),400);
                // }





            try 
            {
                if (Auth::guard('api')->check()) 

                {
                      $job_id=DB::table('jobs')->where([['name',$request->input('job')]])->sharedlock()->value('id');
            // $result=DB::table('workers')->where([['job_id',$job_id]])->sharedlock()->get();
            
            // $json_result=$result->toJson(JSON_FORCE_OBJECT);

            // return response($json_result, 200, ["Content-Type" => "application/json"]);
            // return $job_id ;
            
            $result=DB::table('users')->select(['id','name','avatar','phone','wage','rate','address_id'])->join('workers','users.id','=','workers.user_id')->where([['job_id',$job_id]])->get();

            return response($result,200);              
                }
                else 
                {
                    return response('not authenticated',404);
                }

            } 

            catch (Exception $e) 

            {   
                return response('api error',500);
                
            }
}            




    public function delete()
    {
        try 
        {
         if ($user=Auth::guard('api')->user())
        {
            if ($user->role_id==1) 
            {   
                DB::beginTransaction();
                DB::table('workers')->where([['user_id',$user->id]])->lockForUpdate()->delete();
                DB::table('users')->where([['id',$user->id]])->lockForUpdate()->delete();
                DB::commit();
                                  
            }
            else
            {
                DB::beginTransaction();
                DB::table('users')->where([['id',$user->id]])->lockForUpdate()->delete();
                DB::commit();
            }

                return response('good bye',200);
        }   
        else 
        {
            return response('not authenticated',404);


        }   
        }
         catch (Exception $e) 
         {
            DB::rollBack();
          return  response('server error',500);

         }
    }







public function test()
{
    if (Auth::guard('api')->check())

    {
        return response('that\'s right',200);               

    }
    else 
    {
                             return response(['name'=>'rahman','email'=>'rahman@mail.com','password'=>'password','password_confirmatoin'=>'password'],500) ;            


    }
}





}