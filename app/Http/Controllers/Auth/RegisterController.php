<?php
namespace App\Http\Controllers\Auth;

use DB;
use Mail;
use App\User;
use App\Worker;
use Illuminate\Http\Request;    
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
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
     * 6+++++++++++
     .0return void
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
        if ($data['role_id']==1) {
            return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'role_id'=>'required|integer',
            'phone'=>'required|regex:/(01)[0-9]{9}/',
            'wage'=>'required|integer',
            'password' => 'required|min:6|confirmed',
        ]);
        }
       if ($data['role_id']==2) {
            return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        }
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data00.............
     3*
     * @return User
     */
    protected function create(array $data)
    {
        if($data['role_id']==1) {
            $user=User::create([
                'api_token'=>str_random(60),
                'name' => $data['name'],
                'email' => $data['email'],
                'admin' => 0,
                'role_id' => $data['role_id'],
                'verifyToken'=>str_random(10),
                'password' => bcrypt($data['password']),
            ]);
            $user_id=$user->id;
            $worker=new Worker();
            $worker->user_id=$user_id;
            $worker->job_id=$data['job_id'];
            $worker->phone=(string)$data['phone'];
            $worker->avatar='default.png';
            $worker->wage=$data['wage'];
            $worker->address_id=$data['address_id'];
            $worker->save();
            return $user;
        }
        if($data['role_id']==2)
            # code...
        {
            return User::create([
                'api_token'=>str_random(60),    
                'name' => $data['name'],
                'email' => $data['email'],
                'admin' => 0,
                'role_id' => $data['role_id'],
                'verifyToken'=>str_random(10),
                'password' => bcrypt($data['password']),
            ]);
        }
    }
     protected function register(Request $request){
        $input=$request->all();
        $validator=$this->validator($input);

        if($validator->passes()){
            $data=$this->create($input)->toArray();
            $data['verifyToken']=str_random(25);

            $user=User::findOrFail($data['id']);
            $user->verifyToken=$data['verifyToken'];
            $user->save();

            Mail::send('emails.confirmation',$data,function($message) use($data){
                $message->to($data['email']);
                $message->subject('Registeration Confirmation');

            });
            return redirect('/')->with('m','Confirmation email has been send,please check your email.');
        }
        return redirect('/')->with('m',$validator->errors);
     }
     public function confirmation($verifyToken){
        $user=User::where('verifyToken',$verifyToken)->first();

        if (!is_null($user)) {
            # code...
            $user->verified=1;
            $user->verifyToken='';
            $user->save();

            return redirect('/')->with('m','Your activation is completed');
        }
     return redirect('/')->with('m','Something went wrong');
     }
}