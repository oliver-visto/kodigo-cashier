<?php

use App\Http\Controllers\PaymentController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home',function(){
    return view('home');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/payment/{string}/{price}', [PaymentController::class, 'charge'])->name('goToPayment');
Route::post('payment/process-payment/{string}/{price}', [PaymentController::class, 'processPayment'])->name('processPayment')->middleware('auth');
Route::get('',[PaymentController::class,'reportUsage'])->name('reportUsage')->middleware('auth');
Route::get('/product-checkout', function (Request $request) {
    return $request->user()->checkout('price_tshirt');
});

Route::post('user/subscribe', function (Request $request)
{
    $request->user()->newSubscription(
        'default','price_1MqSPTFrnRRkUcKZ8vWl9VRd'
    )->create($request->paymentMethodId);
})->middleware('auth')->name('subscribe_netflix');