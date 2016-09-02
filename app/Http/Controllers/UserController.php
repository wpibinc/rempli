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
        $adresses = $user->adresses;
        return view('account', ['orders' => $orders, 'user' => $user, 'adresses' => $adresses]);
    }
    
    public function changeInfo(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            return abort(404);
        }
        $param = $request->input('param');
        $value = $request->input('value');
        $user = Auth::user();
        switch($param){
            case 'email': $user->email = $value;
                break;
            case 'password': $user->password = bcrypt($value);
                break;
            case 'phone': $user->phone = $value;
                break;
            case 'fname': $user->fname = $value;
                break;
            case 'sname': $user->sname = $value;
                break;
        }
        $user->save();
    }
}

