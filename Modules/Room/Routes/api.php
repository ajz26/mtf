<?php

use Illuminate\Http\Request;
use Modules\Room\Http\Controllers\RoomController;

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

Route::middleware('auth:api')->get('/room', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->apiResource('rooms',RoomController::class);




Route::middleware('auth:sanctum')->controller(RoomController::class)->prefix('rooms')->group(function () {
    Route::post('{id}/start/', 'start');
    Route::post('{id}/finish/', 'finish');
    Route::post('{id}/subscribe/', 'subscribe');
    Route::post('{id}/unsubscribe/{user?}', 'unsubscribe');
});