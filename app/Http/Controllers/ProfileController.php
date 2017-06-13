<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\Rating;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
     public function profile(){
        return view('profile', array('user' => Auth::user()) );
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
        if($request->hasFile('avatar')){
        $path=$request->file('avatar')->storeAs(
            'avatars', $request->user()->id
        );   
        $user=Auth::user();
        $user->worker->avatar=$path;
        $user->worker->save();
        }

        return view('profile', array('user' => Auth::user()) );
    }
}
