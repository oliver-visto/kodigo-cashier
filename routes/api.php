<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Laravel\Cashier\Http\Controllers\PaymentController as ControllersPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'auth'],function(){
    Route::post('signup',[AuthenticationController::class,'signup']);
    Route::post('login',[AuthenticationController::class,'login']);
    Route::get('logout',[AuthenticationController::class,'logout'])->middleware('auth:api');
});