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
        return redirect()->back()
            ->with('success_message', 'Подписка оформлена');
    }
}
