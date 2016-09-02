<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use Mail;

class TestController extends BaseController
{
    public function index(Request $request)
    {
        Mail::send('emails.register', array('fname' => 'Вася'), function($message)
        {
            $message->to('dmitriy_miheev@mail.ru', 'Вася')->subject('Регистрация прошла успешно');
        });
    }
}

