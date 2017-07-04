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
     * 
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
            'age'=>'required|integer',
            'phone'=>'required|regex:/(01)[0-9]{9}/|unique:workers',
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
     * @param  array 
     * @return User
     */
    protected function create(array $data)
    {
        if($data['role_id']==1) {
            $user=new User([
                'api_token'=>str_random(60),
                'name' => $data['name'],
                'email' => $data['email'],
                'admin' => 0,
                'role_id' => $data['role_id'],
                'verifyToken'=>str_random(10),
                'password' => bcrypt($data['password']),
            ]);
            $worker=new Worker();
            $worker->job_id=$data['job_id'];
            $worker->age=$data['age'];
            $worker->phone=(string)$data['phone'];
            $worker->avatar='public/avatars/default.png';
            $worker->rate=0;
<<<<<<< HEAD
            $worker->no_rates=0;
=======
>>>>>>> master
            $worker->wage=$data['wage'];
            $worker->address_id=$data['address_id'];
            DB::transaction(function() use ($user, $worker) {
                $user->save();
                User::findOrFail($user->id)->worker()->save($worker);
            });
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
        $this->validator($input)->validate();
        if($this->validator($input)->passes()){
            $data=$this->create($input)->toArray();
            $data['verifyToken']=str_random(25);

            $user=User::findOrFail($data['id']);
            $user->verifyToken=$data['verifyToken'];
            $user->save();

            Mail::send('emails.confirmation',$data,function($message) use($data){
                $message->to($data['email']);
                $message->subject('Registeration Confirmation');

            });
        }

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


