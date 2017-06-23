<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Job;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities=City::all();
        $jobs=Job::all();
        return view('home')
            ->withCities($cities)
            ->withJobs($jobs);
    }
    public function get_addresses(Request $request){
        
        $id=$request->id;
        $city=City::find($id);
        $addresses=$city->addresses;
        return response()->json([
        $addresses]);
    
     }
}

