<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/rates', function (Request $request) {




    // log the raw request -- this makes debugging much easier
    // $filename = time();
    // $input = file_get_contents('php://input');
    // file_put_contents($filename . '-input', $input);

    // parse the request
    // $rates = json_decode($input, true);

    // log the array format for easier interpreting
    // file_put_contents($filename . '-debug', print_r($rates, true));

    // total up the cart quantities for simple rate calculations
    $quantity = 5;

    // use number_format because shopify api expects the price to be "25.00" instead of just "25"

    // overnight shipping is 5.50 per item
    $overnight_cost = number_format($quantity * 5.50, 2, '', '');
    // regular shipping is 2.75 per item
    $regular_cost = number_format($quantity * 2.75, 2, '', '');

    // overnight shipping is 1 to 2 days after today
    $on_min_date = date('Y-m-d H:i:s O', strtotime('+1 day'));
    $on_max_date = date('Y-m-d H:i:s O', strtotime('+2 days'));

    // regular shipping is 3 to 7 days after today
    $reg_min_date = date('Y-m-d H:i:s O', strtotime('+3 days'));
    $reg_max_date = date('Y-m-d H:i:s O', strtotime('+7 days'));

    // build the array of line items using the prior values
    $output = array('rates' => array(
        array(
            'service_name' => 'Crowdbotics Overnight',
            'service_code' => 'ETON',
            'total_price' => $overnight_cost,
            'currency' => 'PKR',
            'min_delivery_date' => $on_min_date,
            'max_delivery_date' => $on_max_date
        ),
        array(
            'service_name' => 'Crowdbotics Regular',
            'service_code' => 'ETREG',
            'total_price' => $regular_cost,
            'currency' => 'PKR',
            'min_delivery_date' => $reg_min_date,
            'max_delivery_date' => $reg_max_date
        )
    ));

    // encode into a json response
    $json_output = json_encode($output);

    // log it so we can debug the response
    // file_put_contents($filename . '-output', $json_output);

    // send it back to shopify
    print $json_output;
});

Route::get('/orders', function (Request $request) {
    $orders = DB::table('orders')->get();
    print_r($orders);
});

Route::post('/webhook-orders-create', function (Request $request) {
});
