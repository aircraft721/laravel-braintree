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

        if (!$request->user()->subscribed('main')) {
        $request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);
        } else {
            $request->user()->subscription('main')->swap($plan->braintree_plan);
        }


        return redirect('home')->with('success', 'Subscribed to '. $plan->braintree_plan .' successfully');
    }
}
