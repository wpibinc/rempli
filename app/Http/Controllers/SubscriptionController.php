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
//        return redirect()->back()->with('success_message', 'Подписка оформлена.');
    }
    public function update(Request $request)
    {
        $subscription = Subscription::find($request->id);
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $subscription->getColumnNames())) {
                $subscription->{$key} = trim($value);
            }
        }

        try {
            $subscription->save();
        } catch (\Exception $e) {
            return $e;
        }
//        return redirect()->back()->with('success_message', 'Подписка оформлена.');
    }
}
