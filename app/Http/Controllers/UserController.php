<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\Adress;

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
        $user = Auth::user();
        $action = $request->input('action');
        if($action == 'changepassword'){
            $user->password = bcrypt($request->input('pass'));
        }else{
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->fname = $request->input('fname');
            $user->sname = $request->input('sname');
        }

        $user->save();
    }
    
    public function addAdress(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            return abort(404);
        }
        $user = Auth::user();
        $adress = new Adress();
        $adress->user_id = $user->id;
        $adress->street = $request->input('street');
        $adress->home = $request->input('home');
        $adress->korp = $request->input('korp');
        $adress->flat = $request->input('flat');
        $adress->save();
        return response()->json(['success' => true]);
    }
    
    public function deleteAdress(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            return abort(404);
        }
        $id = $request->input('id');
        Adress::destroy($id);
        return response()->json(['success' => true]);
    }
    
    public function getOrderDetails(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            return abort(404);
        }
        $id = $request->input('id');
        $items = Order::find($id)->items()->get();
        $output = '';
        if($items->count()){
            foreach($items as $item){
                $item->getRelations();
                if($item->product){
                    $output .= '<div class="item"><span class="title">'.$item->product->product_name.'</span><span class="count">'.$item->count.' шт</span><img src="'.$item->product->img.'"></div>';
                    
                }
                if($item->avproduct){
                    $output .= '<div class="item"><span class="title">'.$item->avproduct->name.'</span><span class="count">'.$item->count.' шт</span><img src="http://av.ru'.$item->avproduct->image.'"></div>';
                }
            }
        }
        echo $output;
        die();
    }
}

