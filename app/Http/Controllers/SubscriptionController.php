<?php

namespace App\Http\Controllers;

use App\Subscription;
use Carbon\Carbon;
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

    public function promoCodeCreate(Request $request)
    {
        Subscription::create($request->all());

        return redirect()->back();
//        return redirect()->back()->with('success_message', 'Подписка оформлена.');
    }

    public function promoCodeActivate(Request $request)
    {

        $subscription = Subscription::where('promocode', $request->promocode)->first();
        if ($subscription->start_promocode != null) {
            return response()->json(['status' => false]);
        }
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $subscription->getColumnNames())) {
                $subscription->{$key} = trim($value);
            }
        }

        $subscription->start_promocode = Carbon::now();
        $cur_date = Carbon::now();
        $subscription->end_promocode = $cur_date->addMonths($subscription->duration);
        try {
            $subscription->save();
        } catch (\Exception $e) {
            return $e;
        }
        return response()->json(['status' => true]);
//        return redirect()->back()->with('success_message', 'Подписка оформлена.');
    }
}
