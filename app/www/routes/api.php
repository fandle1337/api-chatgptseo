<?php

use App\Http\Controllers\ControllerBase;
use App\Http\Controllers\ControllerClientActivate;
use App\Http\Controllers\ControllerClientInfo;
use App\Http\Controllers\ControllerClientInstall;
use App\Http\Controllers\ControllerGptPrompt;
//use App\Http\Controllers\ControllerOrderCreate;
//use App\Http\Controllers\ControllerOrderPaymentReceiver;
use App\Http\Middleware\MiddlewareAuthBusClient;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => MiddlewareAuthBusClient::class], function (){
    Route::post('/gpt/prompt/', ControllerGptPrompt::class)->name("gpt.prompt");
    Route::post('/client/install/', ControllerClientInstall::class)->name("client.install");
    Route::post('/client/info/', ControllerClientInfo::class)->name("client.info");

//    отложено для дальнейшей разработки
//    Route::post('/order/create/', ControllerOrderCreate::class)->name("order.create");
//    Route::post('/order/payment/receiver/', ControllerOrderPaymentReceiver::class)->name("order.payment.receiver");
});

Route::post('/client/activate/', ControllerClientActivate::class)->name("client.activate");

Route::any('{any}', function(){
    return (new ControllerBase())->sendError("Путь не найден", 404);
})->where('any', '.*');
