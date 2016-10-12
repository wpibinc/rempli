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

        return response()->json(['status' => true, 'msg' => 'Подписка оформлена.']);
    }
    public function update(Request $request)
    {
        if($request->input_dop == 1) {
            $subscription = Subscription::find($request->id);
            if($subscription->is_free == 0) {
                $subscription->current_quantity += $request->dop_quantity;
                $subscription->price += $request->price;
                try {
                    $subscription->save();
                } catch (\Exception $e) {
                    return $e;
                }
            } else {
                $long_promocodes = LongPromocode::where('subscription_id', $subscription->id)
                    ->where('end_subscription', '>', Carbon::now())->first();
                $long_promocodes->used_per_month -= $request->dop_quantity;
                $subscription->price += $request->price;

                try {
                    $long_promocodes->save();
                } catch (\Exception $e) {
                    return $e;
                }

                try {
                    $subscription->save();
                } catch (\Exception $e) {
                    return $e;
                }
            }

            return response()->json(['status' => true, 'msg' => 'Доп. Доставки успешно куплены.']);
        }

        $last_subscription = Subscription::where('user_id', $request->user_id)
                ->where('is_free', '0')
                ->orderBy('end_subscription', 'desc')->first();

        $subscription = Subscription::create($request->all());

        $subscription->start_subscription = $last_subscription->end_subscription;

        $new_start_date = $last_subscription->end_subscription;
        $subscription->end_subscription = Carbon::parse($new_start_date)->addMonths(1);
        try {
            $subscription->save();
        } catch (\Exception $e) {
            return $e;
        }

        return response()->json(['status' => true, 'msg' => 'Подписка изменена.']);
    }

    public function promoCodeCreate(Request $request)
    {
        Subscription::create($request->all());

        return redirect()->back();
    }

    public function promoCodeActivate(Request $request)
    {

        $subscription = Subscription::where('promocode', $request->promocode)->first();
        if (isset($subscription)) {
            if ($subscription->start_subscription != null) {
                return response()->json(['status' => false, 'msg' => 'Введён неправильный промо-код!']);
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

            return response()->json(['status' => true, 'msg' => 'Промо-код активирован.']);
        } else {
            return response()->json(['status' => false, 'msg' => 'Введён неправильный промо-код!']);
        }
    }
}
