<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Mail;
use Illuminate\Http\Request;
use View;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $username = 'phone';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        View::share('subscription', null);
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
            //'username' => 'required|max:255',
            'phone' => 'required|unique:users',
            'email' => 'required|email|max:255|unique:users',
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
        
        $confCode = rand(999, 9999);
        $smsText = 'Код регистрации rempli.ru:'.$confCode;
        $apiId = 'BAFD72FC-2E9F-6C9F-77BF-4F2BDEEBD21F';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
        $phone = $data['phone'];
        $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $smsText);
        $client->smsSend($sms);
        $args = [
           // 'username' => $data['username'],
            'phone' => $data['phone'],
            'fname' => $data['fname'],
            'sname' => $data['sname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'free_delivery' => 0,
            'confirmation_code' => $confCode,
        ];
        
        return User::create($args);
    }
    
    public function register(Request $request)
    {   
        $this->redirectTo = '/confirm-code';
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );  
        }   

        $this->create($request->all());

        return redirect($this->redirectPath());
    }
    
    protected function getCredentials(Request $request)
    {
        $crendentials=$request->only($this->loginUsername(), 'password');
        $crendentials['confirmed']=1;
        return $crendentials;
    }
}
