<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Job;
use App\Address;
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
        $jobs=Job::all();
        $addresses=Address::all();
        return view('home')
            ->withJobs($jobs)
            ->withAddresses($addresses);
    }
}
