<?php
namespace App\Http\Controllers;
use App\LongPromocode;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Order;
use Auth;
use App\Adress;
use Mail;
use Carbon\Carbon;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $order=request()->except(['_token','items', 'addressChecked']);
            $adressChecked = $request->input('addressChecked');
            $user = Auth::user();
            $order['user_id'] = $user->id;
            $order['shop'] = session('shop');
            $items = request()->only('items');
            if(!empty($adressChecked)){
                $adress = Adress::find($adressChecked);
                $order['address'] = $adress->street;
                $order['house'] = $adress->home;
                $order['korp'] = $adress->korp;
                $order['flat'] = $adress->flat;
            }else{
                $adress = new Adress();
                $adress->street = $order['address'];
                $adress->home = $order['house'];
                $adress->korp = $order['korp'];
                $adress->flat = $order['flat'];
                $adress->user_id = $user->id;
                $adress->save();
            }
            $order= Order::create($order);
            $order->items()->createMany($items['items']);
    
            return ['orderId' => $order->id];
            die();
        }
        $user = Auth::user();
        $date = Carbon::now('Europe/Moscow');
        $orderNow = true;
        if($date->hour >= 20){
            $orderNow = false;
        }
        $orderDate = substr($date->addHour(), 0, -3);

        return view('order', [
            'user' => $user, 
            'date' => $orderDate,
            'orderNow' => $orderNow
        ]);
    }
    
    public function payment(Request $request)
    {
        $user = Auth::user();
        $freeDelivery = true;
        if($user->free_delivery){
            $freeDelivery = false;
        }

        $subscription = $user->subscriptions()->where('end_subscription', '>', Carbon::now())->first();
        $late_invoices = $user->invoices()
            ->where('last_pay_day','<', Carbon::now())
            ->where('is_paid', '0')->first();
        if (isset($subscription)) {
            if($subscription->is_free == 0 && $subscription->current_quantity > 0) {
                $subscription->current_quantity--;
                $freeDelivery = true;
                $subscription->save();
            } elseif ($subscription->is_free == 1) {
                $long_promocodes = LongPromocode::where('subscription_id', $subscription->id)
                ->where('end_subscription', '>', Carbon::now())->first();
                if ($long_promocodes->used_per_month < $subscription->current_quantity) {
                    $long_promocodes->used_per_month++;
                    $freeDelivery = true;
                    $long_promocodes->save();
                }
            }
        }
        if($user->free_delivery_manually){
            $freeDelivery = true;
        }
        if(isset($late_invoices)) {
            $freeDelivery = false;
        }
        return view('payment', ['freeDelivery' => $freeDelivery]);
    }
    
    public function success(Request $request)
    {
        $user = Auth::user();
        if(!$user->free_delivery){
            $user->free_delivery = true;
            $user->save();
        }
        $order = Order::find($_REQUEST['order']);
        $name = $order->name;
        $cost = $order->cost;
//        if($request->method() === 'POST'){
//            
//            if(null === $request->input('name')){
//                $name = $request->input('name');
//            }
//            if(null === $request->input('cost')){
//                $cost = $request->input('cost');
//            }
//            
//            //dd($client->smsStatus($smsId));
//
//            //dd($client->myLimit());
//            return ['ok'];
//        }
        
        
        $apiId = 'BAFD72FC-2E9F-6C9F-77BF-4F2BDEEBD21F';
        $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
    
        $phone = '89645805819';
        $text1 = "$name. Сумма заказа $cost руб.";

        
        
        $userPhone = $user->phone;
        $text2 = 'Ваш заказ на сумму '.$cost.' рублей принят. В ближайшее время мы свяжемся с Вами для подтверждения';
        $sms2 = new \Zelenin\SmsRu\Entity\Sms($userPhone, $text2);
        $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $text1);

        $client->smsSend($sms);
        $client->smsSend($sms2);
        return redirect('/')->with('order', 'success');
    }
}

