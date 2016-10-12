<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\LongPromocode;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\Adress;
use App\User;
use Flash;
use Mail;
use App\ListProduct;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return view('order', ['user' => $user]);
    }
    
    public function myAccount(Request $request)
    {
        $user = Auth::user();
//        $subscriptions = $user->subscriptions()->where('current_quantity', '>', 0)->first();
        $subscriptions = $user->subscriptions()->where('end_subscription', '>', Carbon::now())->first();
        if(isset($subscriptions)) {
            $long_promocode = LongPromocode::where('subscription_id', $subscriptions->id)
                ->where('end_subscription', '>', Carbon::now())->first();
        }
        $orders = Order::where('user_id', $user->id)->simplePaginate(15);
        $listProducts = ListProduct::where('user_id', $user->id)->simplePaginate(15);
        $adresses = $user->adresses;
        if(isset($long_promocode)) {
            $current_quantity = $subscriptions->current_quantity - $long_promocode->used_per_month;
            return view('account', ['orders' => $orders, 'user' => $user, 'adresses' => $adresses, 'listProducts' => $listProducts, 'subscription' => $subscriptions, 'long_promocode' => $long_promocode, 'current_quantity' => $current_quantity]);
        }
        return view('account', ['orders' => $orders, 'user' => $user, 'adresses' => $adresses, 'listProducts' => $listProducts, 'subscription' => $subscriptions]);
    }
    
    public function changeInfo(Request $request)
    {
        if(!$request->isXmlHttpRequest()){
            return abort(404);
        }
        $user = Auth::user();
        $action = $request->input('action');
        if($action == 'changepassword'){
            $pass = $request->input('pass');
            if(strlen($pass)< 6){
                return response()->json(['success' => false, 'message' => 'минимальная	длина	пароля	–	6	символов']);
            }
            $user->password = bcrypt($request->input('pass'));
        }else{
            $email = $request->input('email');
            $phone = $request->input('phone');
            if($email != $user->email){
                $vUser = User::where('email', $email)->get();
                if(count($vUser)){
                    return response()->json(['success' => false, 'err'=> 'email', 'message' => 'E-mail занят']);
                }
                $user->email = $email;
            }
            if($phone != $user->phone){
                $vUser = User::where('phone', $phone)->get();
                if(count($vUser)){
                    return response()->json(['success' => false, 'err'=> 'phone', 'message' => 'телефон занят']);
                }
                $user->phone = $phone;
            }
            $user->fname = $request->input('fname');
            $user->sname = $request->input('sname');
        }

        $user->save();
        return response()->json(['success' => true]);
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
                    $output .= '<div class="item"><div class="info"><span class="title">'.$item->product->product_name.'</span><span class="count">'.$item->count.' шт</span><spav class="price">'.$item->product->price.'</span></div><div class="img"><img src="'.$item->product->img.'"></div></div>';
                    
                }
                if($item->avproduct){
                    $output .= '<div class="item"><div class="info"><span class="title">'.$item->avproduct->name.'</span><span class="count">'.$item->count.' шт</span><spav class="price">'.$item->avproduct->price.'</span></div><div class="img"><img src="http://av.ru'.$item->avproduct->image.'"></div></div>';
                }
            }
        }
        echo $output;
        die();
    }
    
    public function confirmCode(Request $request)
    {
        if($request->isMethod('POST')){
            $this->validate($request, [
                'code' => 'required|min:4|max:4|exists:users,confirmation_code',
            ]);
            $user = User::where('confirmation_code', $request->input('code'))->first();
            $user->confirmed = 1;
            $user->confirmation_code = null;
            $user->save();
            $request->session()->flash('success', 'Код принят. Вы можете войти');
            Mail::send('emails.register', array('fname' => $user->fname), function($message) use ($user)
        {
            $message->to($user->email, $user->fname.' '.$user->sname)->subject('Регистрация прошла успешно. ');
        });
            return redirect('/login');
        }
        return view('auth.confirmcode');
    }
    
    public function addToOrderList(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }
        $products = json_decode($request->input('json'));
        $user = Auth::user();
        if(!$user){
            die();
        }
        foreach($products as $product){
            $shop = '';
            if(isset($product->shop)){
                $shop = $product->shop;
            }
            ListProduct::firstOrCreate([
                'user_id' => $user->id,
                'shop' => $shop,
                'product_id' => $product->id
            ]);
        }
    }
    
    public function clearProductList(Request $request)
    {
        if(!$request->ajax()){
            abort(404);
        }
        $user = Auth::user();
        $productLists = ListProduct::where('user_id', $user->id)->delete();
        if($productLists){
            return response()->json([
                'success' => true,
                'message' => 'Продукты добавлены в корзину'
            ]);
        }
    }
}

