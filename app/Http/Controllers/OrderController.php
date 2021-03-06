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
            $order['shop'] = session('shop')?session('shop'):'Av';
            $orderDate = new Carbon($order['date']);
            switch($order['shop']){
                case 'Me': 
                    $workHours = [12, 23];
                    break;
                case 'La': 
                    $workHours = [12, 23];
                    break;
                default: 
                    $workHours = [10, 23];
                    break;
            }
            if($orderDate->hour<$workHours[0]||$orderDate->hour>=$workHours[1]){
                return ['message' => "Доставка осуществляется с".$workHours[0].".00 до ".$workHours[1].".00", 'success' => false];
            }
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
    
            return ['orderId' => $order->id, 'success' => true];
            die();
        }
        $user = Auth::user();
        $date = Carbon::now('Europe/Moscow');
        $orderNow = true;
        
        $shop = session('shop');
        
        switch($shop){
            case 'Me':$orderDate = substr($date->addHours(3), 0, -3);
                $date->subHours(3);
                if($date->hour >= 20||$date->hour<9){
                    $orderNow = false;
                }
                break;
            case 'La': $orderDate = substr($date->addHours(3), 0, -3);
                $date->subHours(3);
                if($date->hour >= 20||$date->hour<10){
                    $orderNow = false;
                }
                break;
            default : $orderDate = substr($date->addHour(), 0, -3);
                $date->subHour();
                if($date->hour >= 22||$date->hour<9){
                    $orderNow = false;
                }
                break;
        }
        if($shop == 'Me'){
            
        }
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
        $freeDelivery = true;
        if($user->free_delivery){
            $freeDelivery = false;
        }
        if($request->delivery_cost != '0' && !$freeDelivery){
//            $order->delivery_cost = $request->input("delivery_cost");
            $order->delivery_cost = $request->delivery_cost . ' рублей';
        } else {
            $order->delivery_cost = 'Бесплатно!';
        }
        $order->save();
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
        $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $text1);
        $client->smsSend($sms);

        $client2 = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
        $userPhone = $user->phone;
        $replace = [' ', '+7', '-', '(', ')'];
        $userPhone = '8'.str_replace($replace, '', $userPhone);
        $text2 = 'Ваш заказ на сумму '.$cost.' рублей принят. В ближайшее время мы свяжемся с Вами для подтверждения';
        $sms2 = new \Zelenin\SmsRu\Entity\Sms($userPhone, $text2);
        $client2->smsSend($sms2);

        session(['orderSuccess' => true]);
        return redirect('/');
    }
}

