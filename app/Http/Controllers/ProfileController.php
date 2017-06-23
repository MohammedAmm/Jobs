<?php

namespace App\Http\Controllers;
use App\User;
use App\Worker;
use App\Address;
use App\Job;
use Auth;
use App\Rating;
use Illuminate\Http\Request;
use Image;
use Hash;
class ProfileController extends Controller
{
     public function profile(){
        $worker=Auth::user()->worker;
        $jobs=Job::all();
        $jbs=[];
        foreach ($jobs as $job) {
            # code...
            $jbs[$job->id]=$job->name;
        }
        $addresses=Address::all();    
        $ads=[];
        foreach ($addresses as $address) {
            # code...
            $ads[$address->id]=$address->name;
        }
        return view('profile', array('user' => Auth::user()) )
            ->withWorker($worker)
            ->withAddresses($ads)
            ->withJobs($jbs);
    }
    public function show($id)
    {
        //
        $worker=User::find($id)->worker;
        $canRate = Auth::check() && ((Auth::user()->role_id)==2) && Rating::where('user_id', Auth::user()->id)->where('worker_id', $id)->count() == 0;
        return view('workers.index', compact('worker', 'canRate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_info(Request $request)
    {
        //
        $user_id=Auth::user()->id;
        $worker=Auth::user()->worker;
        $this->validate($request,[
                'avatar' =>'image',
                'job_id'=>'required|integer',
                'phone'=>'required|regex:/(01)[0-9]{9}/',
                'address_id'=>'required|integer',
                'wage'=>'required|integer',
            ]);
        if($request->hasFile('avatar')){
        $worker->avatar = $request->avatar->store('public/avatars');     
     }  
        if(isset($request->job_id))
            $job_id=$request->job_id;
        if(isset($request->address_id))
            $address_id=$request->address_id;
        if(isset($request->phone))
            $phone=$request->phone;
        if(isset($request->wage))
            $wage=$request->wage;
        
       $worker->job_id=$job_id;
       $worker->phone=$phone;
       $worker->address_id=$address_id;
       $worker->wage=$wage;
     $worker->save();
     $request->session()->flash('flash_message', 'Ur Info Successfully Updated');
     return redirect()->back();
    }
    public function change_page(){
        return view('auth.changepassword');
    }
    public function change_password(Request $request){
        $user=User::findOrFail(Auth::user()->id);
        $this->validate($request,[
                'password'=>'required|min:6|confirmed'

            ]);
        if (Hash::check($request->passwordold,$user->password)&&$request->password==$request->password_confirmation) {
            # code...
            $user->password=bcrypt($request->password);
            $user->save();
            $request->session()->flash('password_message', 'Password Successfully Changed');
        }
       else {
           # code...
            $request->session()->flash('password_message_error', 'Current Password Not Correct');
       }
        return redirect()->back();
    }
}
