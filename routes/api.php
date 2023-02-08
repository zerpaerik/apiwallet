<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RevertController;
use App\Http\Controllers\NullifyController;

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
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment', [PaymentController::class, 'execute'])->name('payment');
Route::post('/revert', [RevertController::class, 'execute'])->name('revert');
Route::post('/nullify', [NullifyController::class, 'execute'])->name('nullify');