<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/plans', 'PlansController@index');

Route::group(['middleware'=>'auth'], function(){
    Route::get('/plan/{plan}', 'PlansController@show');
    Route::get('/braintree/token', 'BraintreeTokenController@token');
    Route::post('/subscribe', 'SubscriptionsController@store');
    Route::get('/lessons','LessonsController@index');
    Route::group(['middleware'=>'subscribed'], function(){
        Route::get('/lessons','LessonsController@index');
        Route::get('/subscriptions','SubscriptionsController@index');
        Route::get('/subscriptions/cancel', 'SubscriptionsController@cancel');
        Route::get('/subscriptions/resume', 'SubscriptionsController@resume');

    });
    Route::group(['middleware'=>'premium-subscribed'], function(){
        Route::get('/prolessons','LessonsController@premium');
    });
});
