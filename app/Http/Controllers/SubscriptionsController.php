<?php

namespace App\Http\Controllers;
use App\Plan;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function store(Request $request){
        $plan = Plan::findOrFail($request->plan);

        if ($request->user()->subscribedToPlan($plan->braintree_plan, 'main')) {
            return redirect('home')->with('error', 'Unauthorised operation');
        }

        $request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);

        return redirect('home');
    }
}
