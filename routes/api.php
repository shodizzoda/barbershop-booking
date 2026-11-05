<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [AuthController::class, 'login']);
Route::get('/services', [ServiceController::class, 'index']);

Route::middleware('auth:sanctum')->group(function(){
   
    Route::patch('/appointments/{id}/cancel', [AppointmentController::class, 'cancel']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::post('/logout', [AuthController::class, 'logout']);

});

Route::prefix('admin')->middleware(['auth:sanctum', Admin::class])->group(function(){
    Route::apiResource('services', AdminServiceController::class);

});