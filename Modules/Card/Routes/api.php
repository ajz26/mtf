<?php

use Illuminate\Http\Request;
use Modules\Card\Http\Controllers\CardController;

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

Route::middleware('auth:api')->get('/card', function (Request $request) {
    return $request->user();
});


Route::apiResource('cards',CardController::class);