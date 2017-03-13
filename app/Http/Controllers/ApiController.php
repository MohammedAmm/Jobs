<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB ;
class ApiController extends Controller
{
     public function user_reg()
    {
    	DB::table('users')->insert(

    	[
                'api_token'=>str_random(60),
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'role_id' => $_POST['role_id'],
                'password' => bcrypt($_POST['password'])
                // password encryption at client side is recommended


            ]);

    }
}
