<?php
namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Order;
use Auth;

class OrderController extends BaseController
{
    public function index(Request $request)
    {
        if($request->isXmlHttpRequest()){
            $order=request()->except(['_token','items']);
            $user = Auth::user();
            $order['user_id'] = $user->id;
            $items = request()->only('items');

            $order= Order::create($order);
            $order->items()->createMany($items['items']);
    
            return ['ok'];
            die();
        }
        $user = Auth::user();
        return view('order', ['user' => $user]);
    }
    
    public function payment(Request $request)
    {
        $user = Auth::user();
        $freeDelivery = true;
        if($user->free_delivery){
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
        
        if($request->method() === 'POST'){
            $name = '';
            $cost = '';
            if(null === $request->input('name')){
                $name = $request->input('name');
            }
            if(null === $request->input('cost')){
                $cost = $request->input('cost');
            }
            $apiId = 'BAFD72FC-2E9F-6C9F-77BF-4F2BDEEBD21F';
            $client = new \Zelenin\SmsRu\Api(new \Zelenin\SmsRu\Auth\ApiIdAuth($apiId));
    
            $phone = '89645805819';
            $text = "$name. Сумма заказа $cost руб.";
    
            $sms = new \Zelenin\SmsRu\Entity\Sms($phone, $text);
    
            $client->smsSend($sms);

            //dd($client->smsStatus($smsId));

            //dd($client->myLimit());
            return ['ok'];
        }

        return view('success');
    }
}

