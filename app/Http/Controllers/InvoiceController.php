<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class InvoiceController extends Controller
{
    public function over8kg(Request $request)
    {
        Invoice::create([
            'user_id' => $request->user_id,
            'order_id' => $request->order_id,
            'title' => $request->title,
            'price' => $request->price,
            'last_pay_day' => Carbon::now()->addDay(3)
        ]);

        return response()->json(['status' => true, 'msg' => 'Счёт успешно выставлен.']);
    }

    public function checkOrder(Request $request)
    {
        $config = [];
        $config['shopId'] 			= '78360';
        $config['ShopPassword'] 	= 'K0mkCkCfjB7mOyyJdn4n';

        print '<?xml version="1.0" encoding="UTF-8"?>';
        print '<checkOrderResponse performedDatetime="'. $request->requestDatetime .'" code="0" invoiceId="'. $request->invoiceId .'" shopId="'. $config['shopId'] .'"/>';
    }

    public function paymentAviso(Request $request)
    {
        $config = [];
        $config['shopId'] 			= '78360';
        $config['ShopPassword'] 	= 'K0mkCkCfjB7mOyyJdn4n';

        $hash = md5($request->action.';'.$request->orderSumAmount.';'.$request->orderSumCurrencyPaycash.';'.$request->orderSumBankPaycash.';'.$config['shopId'].';'.$request->invoiceId.';'.$request->customerNumber.';'.$config['ShopPassword']);
        if (strtolower($hash) != strtolower($request->md5)){
            $code = 1;
        }
        else {
            $code = 0;
            if(isset($request->orderNumber)){
                $invoice = Invoice::find($request->orderNumber);
                $invoice->is_paid = 1;
                $invoice->save();
            } else {
                $subscription = Subscription::create([
                    'user_id' => $request->customerNumber,
                    'current_quantity' => $request->label,
                    'total_quantity' => $request->label,
                    'price' => $request->orderSumAmount,
                ]);
                $subscription->start_subscription = Carbon::now();
                $cur_date = Carbon::now();
                $subscription->end_subscription = $cur_date->addMonths(1);
                    $subscription->save();

//                return response()->json(['status' => true, 'msg' => 'Подписка оформлена.']);
            }
        }
        print '<?xml version="1.0" encoding="UTF-8"?>';
        print '<checkOrderResponse performedDatetime="'. $request->requestDatetime .'" code="'.$code.'"'. ' invoiceId="'. $request->invoiceId .'" shopId="'. $config['shopId'] .'"/>';
    }
}
