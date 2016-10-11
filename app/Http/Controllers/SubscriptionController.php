<?php

namespace App\Http\Controllers;

use App\LongPromocode;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class SubscriptionController extends Controller
{
    public function create(Request $request)
    {
        $subscription = Subscription::create($request->all());
        $subscription->start_subscription = Carbon::now();
        $cur_date = Carbon::now();
        $subscription->end_subscription = $cur_date->addMonths(1);
        try {
            $subscription->save();
        } catch (\Exception $e) {
            return $e;
        }

        return response()->json(['status' => true]);
    }
    public function update(Request $request)
    {
        $last_subscription = Subscription::where('user_id', $request->user_id)
                ->where('is_free', '0')
                ->orderBy('end_subscription', 'desc')->first();

        $subscription = Subscription::create($request->all());

        $subscription->start_subscription = $last_subscription->end_subscription;
        $new_start_date = $last_subscription->end_subscription;
        $subscription->end_subscription = $new_start_date->addMonths(1);
        try {
            $subscription->save();
        } catch (\Exception $e) {
            return $e;
        }

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
        if (isset($subscription)) {
            if ($subscription->start_subscription != null) {
                return response()->json(['status' => false]);
            }
            foreach ($request->all() as $key => $value) {
                if (in_array($key, $subscription->getColumnNames())) {
                    $subscription->{$key} = trim($value);
                }
            }

            $subscription->start_subscription = Carbon::now();
            $cur_date = Carbon::now();
            $subscription->end_subscription = $cur_date->addMonths($subscription->duration);
            try {
                $subscription->save();
            } catch (\Exception $e) {
                return $e;
            }

            for($i = 1; $i <= $subscription->duration; $i++) {
                LongPromocode::create([
                    'subscription_id' => $subscription->id,
                    'used_per_month' => 0,
                    'end_subscription' => Carbon::now()->addMonths($i),
                ]);
            }


            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }

//        return redirect()->back()->with('success_message', 'Подписка оформлена.');
    }
}
