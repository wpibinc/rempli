<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use Mail;
use App\User;

class TestController extends BaseController
{
    public function index(Request $request)
    {
        Mail::send('emails.register', array('fname' => 'Вася'), function($message)
        {
            $message->to('dmitriy_miheev@mail.ru', 'Вася')->subject('Регистрация прошла успешно');
        });
    }
    
    public function allusersactive(Request $request)
    {
        $users = User::all();
        foreach ($users as $user){
            $user->confirmation_code = 1;
            $user->save();
        }
        echo "ok";
        die();
    }
}

