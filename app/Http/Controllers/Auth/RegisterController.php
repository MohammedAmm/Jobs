<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Worker;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role_id'=>'required|integer',
            'password' => 'required|min:6|confirmed',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        if($data['role_id']===1) {
            $user=User::create([
                'api_token'=>str_random(60),
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => bcrypt($data['password']),
            ]);
            $user_id=$user->id;
            $worker=new Worker();
            $worker->user_id=$user_id;
            $worker->job_id=$data['job_id'];
            $worker->phone=$data['phone'];
            $worker->address_id=$data['address_id'];
            $worker->save();
            return $user;
        }
        else{
            return User::create([
                'api_token'=>str_random(60),
                'name' => $data['name'],
                'email' => $data['email'],
                'role_id' => $data['role_id'],
                'password' => bcrypt($data['password']),
            ]);
        }
    }




}
