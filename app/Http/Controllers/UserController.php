<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Order;
use Auth;

class UserController extends BaseController
{
    public function index(Request $request)
    {
        return view('order', ['user' => $user]);
    }
    
    public function myAccount(Request $request)
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        return view('account', ['orders' => $orders]);
    }
}

