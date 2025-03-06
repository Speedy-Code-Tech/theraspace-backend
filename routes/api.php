<?php

use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\TheraphistConrtoller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', [AdminController::class, 'hello']);
Route::get('/sched', [AdminScheduleController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::prefix('child')->middleware('auth:sanctum')->group(function () {
    Route::post('/add', [ChildrenController::class, 'store']);
    Route::get('/{id}', [ChildrenController::class, 'show']);
    Route::post('/delete', [ChildrenController::class, 'destroy']);
});

Route::prefix('theraphist')->middleware('auth:sanctum')->group(function () {
    Route::post('/add', [TheraphistConrtoller::class, 'store']);
    Route::get('/{id}', [TheraphistConrtoller::class, 'show']);
    Route::post('/delete', [TheraphistConrtoller::class, 'destroy']);
});

Route::post('/sendOtp', action: [OTPController::class, 'sendOTP']);
Route::post('/verifyOtp',  [OTPController::class, 'verifyOTP']);

Route::prefix('admin')->group(function () {
    Route::post('/schedule', [AdminScheduleController::class, 'store']);
});

Route::prefix('appointment')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);
    Route::post('/add', [AppointmentController::class, 'store']);
    Route::get('/{id}', [AppointmentController::class, 'show']);
    Route::post('/delete', [AppointmentController::class, 'destroy']);
});
