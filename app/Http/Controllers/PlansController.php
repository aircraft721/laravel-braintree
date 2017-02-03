<?php

namespace App\Http\Controllers;
use App\Plan;
use Illuminate\Http\Request;

class PlansController extends Controller
{
    public function index(){
        return view('plans.index')->with(['plans'=>Plan::get()]);
    }
}
