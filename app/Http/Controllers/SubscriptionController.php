<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\LongPromocode;
use App\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;

class SubscriptionController extends Controller
{
    public function update(Request $request)
    {
        //Покупка Дополнительных Доставок
        if($request->input_dop == 1) {
            $subscription = Subscription::find($request->id);
            $subscription->extra_deliveries_total += $request->dop_quantity;
            $subscription->extra_deliveries_price += $request->price;
            if($subscription->is_free == 0) {
                $subscription->current_quantity += $request->dop_quantity;
            } else {
                $long_promocodes = LongPromocode::where('subscription_id', $subscription->id)
                    ->where('end_subscription', '>', Carbon::now())->first();
                $long_promocodes->used_per_month -= $request->dop_quantity;
                try {
                    $long_promocodes->save();
                } catch (\Exception $e) {
                    return $e;
                }
            }
            try {
                $subscription->save();
            } catch (\Exception $e) {
                return $e;
            }

            Invoice::create([
                'user_id' => $request->user_id,
                'subscription_id' => $request->id,
                'title' => 'Дополнительные доставки',
                'price' => $request->price,
                'last_pay_day' => Carbon::now()->addDay(3),
                'extra_deliveries' => $request->dop_quantity
            ]);

            return response()->json(['status' => true, 'msg' => 'Дополнительные доставки успешно куплены.']);
        }

        //Изменение числа доставок в будущей подписке
        $last_subscription = Subscription::where('user_id', $request->user_id)
//                ->where('is_free', '0')
                ->orderBy('end_subscription', 'desc')->first();

        if($last_subscription->start_subscription > Carbon::now()) {
            if($last_subscription->created_at != $last_subscription->updated_at) {
                return response()->json(['status' => false, 'msg' => 'Вы не можете изменять условия подписки более одного раза.']);
            }
            $invoice = $last_subscription->invoices()->where('last_pay_day', $last_subscription->start_subscription)->first();
            if(!$invoice->is_paid) {
                $last_subscription->current_quantity = $request->current_quantity;
                $last_subscription->total_quantity = $request->total_quantity;
                $last_subscription->price = $request->price;
                try {
                    $last_subscription->save();
                } catch (\Exception $e) {
                    return $e;
                }
                $invoice->price = $request->price;
                try {
                    $invoice->save();
                } catch (\Exception $e) {
                    return $e;
                }
            } else {
                return response()->json(['status' => false, 'msg' => 'Не удалось изменить. Ваша подписка уже проплачена.']);
            }
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

    public function updateOnClick(Request $request)
    {
        $last_subscription = Subscription::where('user_id', $request->user_id)
            ->where('is_free', '0')
            ->orderBy('end_subscription', 'desc')->first();

        if($last_subscription->start_subscription > Carbon::now()) {
            $invoice = $last_subscription->invoices()->where('last_pay_day', $last_subscription->start_subscription)->first();

            if(!$invoice->is_paid && !$request->auto_subscription) {
                $last_subscription->delete();
                $invoice->delete();
                return response()->json(['status' => false, 'msg' => 'Ваша подписка на следующий месяц отменена.']);
            } else {
                return response()->json(['status' => false, 'msg' => 'Не удалось изменить. Ваша подписка уже проплачена.']);
            }
        } else {
            $subscription = Subscription::create($request->all());
            $subscription->start_subscription = $last_subscription->end_subscription;
            $new_start_date = $last_subscription->end_subscription;
            $subscription->end_subscription = Carbon::parse($new_start_date)->addMonths(1);

            try {
                $subscription->save();
            } catch (\Exception $e) {
                return $e;
            }

            Invoice::create([
                'user_id' => $request->user_id,
                'subscription_id' => $subscription->id,
                'title' => 'Продление подписки',
                'price' => $request->price,
                'last_pay_day' => $last_subscription->end_subscription
            ]);
        }
        return response()->json(['status' => true, 'msg' => '']);
    }

    public function updatePromocode(Request $request)
    {
        $last_subscription = Subscription::where('user_id', $request->user_id)
//            ->where('is_free', '0')
            ->orderBy('end_subscription', 'desc')->first();

        if($last_subscription->start_subscription > Carbon::now()) {
            $invoice = $last_subscription->invoices()->where('last_pay_day', $last_subscription->start_subscription)->first();

            if(!$invoice->is_paid && $request->button_action == "Удалить") {
                $last_subscription->delete();
                $invoice->delete();
                return response()->json(['status' => false, 'msg' => 'Ваша следующая подписка отменена.']);
            } else {
                return response()->json(['status' => false, 'msg' => 'Не удалось изменить. Ваша подписка уже проплачена.']);
            }
        } else {
            $subscription = Subscription::create($request->all());
            $subscription->auto_subscription = 1;
            $subscription->start_subscription = $last_subscription->end_subscription;
            $new_start_date = $last_subscription->end_subscription;
            $subscription->end_subscription = Carbon::parse($new_start_date)->addMonths(1);

            try {
                $subscription->save();
            } catch (\Exception $e) {
                return $e;
            }

            Invoice::create([
                'user_id' => $request->user_id,
                'subscription_id' => $subscription->id,
                'title' => 'Продление подписки',
                'price' => $request->price,
                'last_pay_day' => $last_subscription->end_subscription
            ]);
        }
        return response()->json(['status' => true, 'msg' => 'Ваша подписка продлена.']);
    }
}
