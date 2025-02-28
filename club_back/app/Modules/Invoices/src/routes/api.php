<?php
use holoo\modules\Invoices\Http\Controllers as Controllers;
use Illuminate\Support\Facades\Route;

Route::apiResource('invoices', Controllers\InvoiceController::class);

 Route::post('invoice/getSeries', [Controllers\InvoiceController::class,'getSeries']);

