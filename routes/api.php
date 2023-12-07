<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\V1\SearchDispatchDateController;
use App\Http\Controllers\V1\SearchPaymentDateController;

Route::prefix('/v1')->group(function () {
    Route::get('/search/payment_date', SearchPaymentDateController::class);
    Route::get('/search/dispatch_date', SearchDispatchDateController::class);
});
