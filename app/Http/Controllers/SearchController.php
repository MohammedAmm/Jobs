<?php

namespace App\Http\Controllers;

use Request;
use App\Worker;
class SearchController extends Controller
{
    //
    public function search()
    {
    	# code...
		
    	$name=Request::get('nam');
    	$address=Request::get('adr');
    	$results=Worker::where('job_id','=',$name)
    		->where('address_id','=',$address)
			->orderBy('rate','desc')
			->paginate(5);    	
    	return view('results')->withResults($results);
    }
}
