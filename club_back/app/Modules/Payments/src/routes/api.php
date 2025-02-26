<?php
use holoo\modules\Payments\Http\Controllers as Controllers;
use Illuminate\Support\Facades\Route;


Route::get('/payments/pay', [Controllers\PaymentController::class, 'pay']);

Route::get('payments/callback/verify', [Controllers\PaymentController::class, 'verify']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('transactions', Controllers\TransactionController::class);
    Route::post('transactions/search', [Controllers\TransactionController::class, 'search']);
});

