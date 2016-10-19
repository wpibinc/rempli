<?php

namespace App\Http\Controllers;

use App\Invoice;
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
}
