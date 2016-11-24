<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class InvoiceController extends Controller
{
    public $allowArray = [
        0 => [4 => 1600],
        1 => [8 => 3000],
        2 => [12 => 4200],
        3 => [30 => 7500]
    ];


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

        $hash = md5($request->action.';'.$request->orderSumAmount.';'.$request->orderSumCurrencyPaycash.';'.$request->orderSumBankPaycash.';'.$config['shopId'].';'.$request->invoiceId.';'.$request->customerNumber.';'.$config['ShopPassword']);
        if (strtolower($hash) != strtolower($request->md5)){
            $code = 1;
        }
        else {
            if(isset($request->orderNumber)){
                $invoice = Invoice::find($request->orderNumber);
                if($invoice->price == $request->orderSumAmount && $invoice->id == $request->orderNumber) {
                    $code = 0;
                } else {
                    $code = 1;
                }
            } elseif( $this->my_in_array($this->allowArray, $request->label, $request->orderSumAmount) ) {
                $code = 0;
            } else {
                $code = 1;
            }
        }

        print '<?xml version="1.0" encoding="UTF-8"?>';
        print '<checkOrderResponse performedDatetime="'. $request->requestDatetime .'" code="'.$code.'"'. ' invoiceId="'. $request->invoiceId .'" shopId="'. $config['shopId'] .'"/>';
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
            if(isset($request->orderNumber)){
                $invoice = Invoice::find($request->orderNumber);
                if($invoice->price == $request->orderSumAmount && $invoice->id == $request->orderNumber) {
                    $invoice->is_paid = 1;
                    $invoice->save();
                    $code = 0;
                } else {
                    $code = 1;
                }
            } elseif( $this->my_in_array($this->allowArray, $request->label, $request->orderSumAmount) ) {
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
                $code = 0;
            } else {
                $code = 1;
            }
        }
        print '<?xml version="1.0" encoding="UTF-8"?>';
        print '<paymentAvisoResponse performedDatetime="'. $request->requestDatetime .'" code="'.$code.'"'. ' invoiceId="'. $request->invoiceId .'" shopId="'. $config['shopId'] .'"/>';
    }

    public function my_in_array($array, $key, $val) {
        foreach ($array as $item)
            if (isset($item[$key]) && $item[$key] == $val)
                return true;
        return false;
    }
}
