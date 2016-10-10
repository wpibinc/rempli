<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

use App\Http\Requests;

class SubscriptionController extends Controller
{
    public function create(Request $request)
    {
        Subscription::create($request->all());
        return response()->json(['status' => true]);
    }
    public function update(Request $request)
    {
        Subscription::create($request->all());
        return response()->json(['status' => true]);
    }

//    public function promoCodeIndex()
//    {
////        return $this->renderContent(view('admin.promocode'));
//        return view('admin.promocode');
//    }

    public function promoCodeCreate(Request $request)
    {
        Subscription::create($request->all());

        return redirect()->back();
//        return redirect()->back()->with('success_message', 'Подписка оформлена.');
    }
}
