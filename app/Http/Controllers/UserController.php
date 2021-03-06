<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Invoice;
use App\LongPromocode;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\Adress;
use App\User;
use Flash;
//use Illuminate\Support\Facades\Mail;
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
        $is_paid_next_subscription = false;
        $has_next_subscription = false;
        $user = Auth::user();
        $time_to_pay = null;
        $next_subscription = null;
        $subscriptions = $user->subscriptions()->where('end_subscription', '>', Carbon::now())->first();
        $late_invoice = $user->invoices()->where('is_paid', '0')
            ->where('title', '!=', 'Продление подписки')->first();
        if(isset($late_invoice)) {
            $time_to_pay = 'У Вас имеются неоплаченные счета';
        }
        if(isset($subscriptions)) {
            $long_promocode = LongPromocode::where('subscription_id', $subscriptions->id)
                ->where('end_subscription', '>', Carbon::now())->first();
        }

        if(isset($subscriptions) /*&& $subscriptions->is_free == '0'*/) {
            $next_subscription = $user->subscriptions()->where('end_subscription', '>', Carbon::now())
                ->where('start_subscription', $subscriptions->end_subscription)->first();

            if(isset($next_subscription)) {
//                header('Content-Type: text/html; charset=utf-8');
//                echo "<pre>";
//                var_dump($next_subscription);
//                echo "</pre>";
//                die();
                $has_next_subscription = true;
                $paid_next_sudscription = $next_subscription->invoices()
                            ->where('last_pay_day', $next_subscription->start_subscription)
                            ->where('is_paid', '1')
                            ->first();
                if (isset($paid_next_sudscription)) {
                    $is_paid_next_subscription = true;
                }

                $invoice = Invoice::where('is_paid', '0')
                    ->where('subscription_id', $next_subscription->id)
                    ->where('last_pay_day', $next_subscription->start_subscription)->first();

                if (isset($invoice) && Carbon::now()->addDay(3) > $invoice->last_pay_day) {
                    $time_to_pay = 'У Вас имеются неоплаченные счета';
                }
            }
        }
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->simplePaginate(15);
        $shop = session('shop')?session('shop'):'Av';
        $listProducts = ListProduct::where('user_id', $user->id)
                ->where('shop', $shop)
                ->simplePaginate(15);
        $adresses = $user->adresses;
        $invoices = $user->invoices()->where('is_paid', '0')
            ->where('last_pay_day', '<', Carbon::now()->addDay(3))
            ->get();
        if($invoices->count() > 0) {
            $time_to_pay = 'У Вас имеются неоплаченные счета';
        }

        if(isset($long_promocode)) {
            $current_quantity = $subscriptions->current_quantity - $long_promocode->used_per_month;
            return view('account', ['orders' => $orders, 'user' => $user, 'adresses' => $adresses, 'listProducts' => $listProducts,
                                    'subscription' => $subscriptions, 'long_promocode' => $long_promocode,
                                    'current_quantity' => $current_quantity, 'invoices' => $invoices, 'time_to_pay' => $time_to_pay,
                                    'has_next_subscription' => $has_next_subscription, 'is_paid_next_subscription' => $is_paid_next_subscription,
                                    'next_subscription' => $next_subscription]);

        }
        return view('account', ['orders' => $orders, 'user' => $user, 'adresses' => $adresses, 'listProducts' => $listProducts,
                                'subscription' => $subscriptions, 'time_to_pay' => $time_to_pay, 'invoices' => $invoices,
                                'has_next_subscription' => $has_next_subscription, 'is_paid_next_subscription' => $is_paid_next_subscription,
                                'next_subscription' => $next_subscription]);
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
                    $img = $item->product->img?$item->product->img:$item->product->image;
                    $name = $item->product->product_name?$item->product->product_name:$item->product->name;
                    $output .= '<div class="item"><div class="info"><span class="title">'.$name.'</span><span class="count">'.$item->count.' шт</span><spav class="price">'.$item->product->price.'</span></div><div class="img"><img src="'.$img.'"></div></div>';
                    
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
            if(!isset($product->shop)||!$product->shop){
                continue;
            }
            ListProduct::firstOrCreate([
                'user_id' => $user->id,
                'shop' => $product->shop,
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
        $shop = session('shop')?session('shop'):'Av';
        $productLists = ListProduct::where('user_id', $user->id)
                ->where('shop', $shop)
                ->delete();
        if($productLists){
            return response()->json([
                'success' => true,
                'message' => 'Продукты добавлены в корзину'
            ]);
        }
    }
}

