<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\CurrencyConversionPairsController;
use App\Http\Controllers\Api\CurrencyConverterController;

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


Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);
Route::middleware('auth:sanctum')->post('/currency', [CurrencyController::class, 'store']);
Route::middleware('auth:sanctum')->get('/currencies', [CurrencyController::class, 'index']);
Route::middleware('auth:sanctum')->get('/currencies/lists', [CurrencyController::class, 'listCurrency']);
Route::middleware('auth:sanctum')->get('/currency/{id}', [CurrencyController::class, 'show']);
Route::middleware('auth:sanctum')->put('/currency/{id}', [CurrencyController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/currency/{id}', [CurrencyController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/currency_convert_pairs', [CurrencyConversionPairsController::class, 'index']);
Route::middleware('auth:sanctum')->post('/currency_convert_pair', [CurrencyConversionPairsController::class, 'store']);
Route::middleware('auth:sanctum')->post('/currency_convert_pair/code', [CurrencyConversionPairsController::class, 'storeByCode']);
Route::middleware('auth:sanctum')->put('/currency_convert_pair/{id}', [CurrencyConversionPairsController::class, 'update']);
Route::middleware('auth:sanctum')->delete('/currency_convert_pair/{id}', [CurrencyConversionPairsController::class, 'destroy']);
Route::get('/currency_converter/{from_currency}/{to_currency}/{amount}', [CurrencyConverterController::class,'convert']);