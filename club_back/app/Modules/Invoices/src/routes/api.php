<?php
use holoo\modules\Invoices\Http\Controllers as Controllers;
use Illuminate\Support\Facades\Route;

Route::apiResource('invoices', Controllers\InvoiceController::class);

// Route::post('invoices/getSeries', [Controllers\InvoiceController::class,'getSeries']);


// Route::controller(Controllers\InvoiceController::class)->group(function () {
//     Route::get('invoices/{show}', 'show');
// });
