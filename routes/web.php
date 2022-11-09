<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {




    $shop = Auth::user();
    $domain = $shop->getDomain()->toNative();



    $json_data = ["carrier_service_id" => 65528168758, "name" => "Sapra Service", "callback_url" => env('APP_URL') . "/api/rates", "service_discovery" => true];
    // $json_data = json_encode($json_data);

    $data_to_be_saved = ['carrier_service' => $json_data];
    $shopApi = $shop->api()->rest('PUT', '/admin/api/2022-10/carrier_services/65528168758.json', $data_to_be_saved, ["Content-Type" => "application/json"]);
    // $shopApi = $shop->api()->rest('GET', '/admin/api/2022-10/carrier_services.json');
    // $shopApi = $shop->api()->rest('GET', '/admin/api/2022-10/webhooks.json');

    echo  json_encode($shopApi);




    // print_r($shopApi);
    // return view('welcome');
})->middleware(['verify.shopify'])->name('home');


Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);
