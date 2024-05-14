<?php

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StrategyOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('backoffice')->group(function () {
//    Route::get('/orders', [OrderController::class, 'filter']);
    Route::get('/orders', [StrategyOrderController::class, 'filter']);
});
