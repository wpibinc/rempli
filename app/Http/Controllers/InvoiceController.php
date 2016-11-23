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
//        $config = [];
//        $config['shopId'] 			= '';
//        $config['scId'] 			= '';
//        $config['ShopPassword'] 	= '';

        $hash = md5($request->action.';'.$request->orderSumAmount.';'.$request->orderSumCurrencyPaycash.';'.$request->orderSumBankPaycash.';'.$request->shopId.';'.$request->invoiceId.';'.$request->customerNumber.';'.$request->ShopPassword);
//        $hash = md5($request->action.';'.$request->orderSumAmount.';'.$request->orderSumCurrencyPaycash.';'.$request->orderSumBankPaycash.';'.$config['shopId'].';'.$request->invoiceId.';'.$request->customerNumber.';'.$config['ShopPassword']);
        if (strtolower($hash) != strtolower($request->md5)){
            $code = 1;
        }
        else {
            $code = 0;
        }
        print '<?xml version="1.0" encoding="UTF-8"?>';
        print '<checkOrderResponse performedDatetime="'. $request->requestDatetime .'" code="'.$code.'"'. ' invoiceId="'. $request->invoiceId .'" shopId="'. $request->shopId .'"/>';
    }

    public function paymentAviso(Request $request)
    {
        $hash = md5($request->action.';'.$request->orderSumAmount.';'.$request->orderSumCurrencyPaycash.';'.$request->orderSumBankPaycash.';'.$request->shopId.';'.$request->invoiceId.';'.$request->customerNumber.';'.$request->ShopPassword);
//        $hash = md5($request->action.';'.$request->orderSumAmount.';'.$request->orderSumCurrencyPaycash.';'.$request->orderSumBankPaycash.';'.$config['shopId'].';'.$request->invoiceId.';'.$request->customerNumber.';'.$config['ShopPassword']);
        if (strtolower($hash) != strtolower($_POST['md5'])){
            $code = 1;
        }
        else {
            $code = 0;
            if(isset($request->orderNumber)){
                $invoice = Invoice::find($request->orderNumber);
                $invoice->is_paid = 1;
                $invoice->save();
            } else {
//                $subscription = Subscription::create($request->all());
                $subscription = Subscription::create([
                    'user_id' => $request->customerNumber,
                    'current_quantity' => $request->quantity,
                    'total_quantity' => $request->quantity,
                    'price' => $request->orderSumAmount,
                ]);
                $subscription->start_subscription = Carbon::now();
                $cur_date = Carbon::now();
                $subscription->end_subscription = $cur_date->addMonths(1);
                try {
                    $subscription->save();
                } catch (\Exception $e) {
                    return $e;
                }

                return response()->json(['status' => true, 'msg' => 'Подписка оформлена.']);
            }
        }
        print '<?xml version="1.0" encoding="UTF-8"?>';
        print '<checkOrderResponse performedDatetime="'. $request->requestDatetime .'" code="'.$code.'"'. ' invoiceId="'. $request->invoiceId .'" shopId="'. $request->shopId .'"/>';
    }
}
