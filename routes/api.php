<?php

use App\Http\Controllers\AdminScheduleController;
use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\TheraphistConrtoller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/users', function (Request $request) {
    return $request->user();
})->middleware(['auth:sanctum', 'role:admin']);


Route::get('/test', [AdminController::class, 'hello']);
Route::get('/sched', [AdminScheduleController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/sendOtp',  [OTPController::class, 'sendOTP']);
Route::post('/verifyOtp',  [OTPController::class, 'verifyOTP']);
Route::put('/user/edit', [AuthController::class, 'edit'])->middleware('auth:sanctum');

Route::prefix('child')->middleware('auth:sanctum')->group(function () {
    Route::post('/add', [ChildrenController::class, 'store']);
    Route::get('/{id}', [ChildrenController::class, 'show']);
    Route::post('/delete', [ChildrenController::class, 'destroy']);
});


Route::prefix('appointment')->middleware(['auth:sanctum', 'role:user'])->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);
    Route::post('/add', [AppointmentController::class, 'store']);
    Route::get('/{id}', [AppointmentController::class, 'show']);
    Route::post('/delete', [AppointmentController::class, 'destroy']);
});



Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::prefix('theraphist')->group(function () {
        Route::post('/add', [TheraphistConrtoller::class, 'store']);
        Route::get('/{id}', [TheraphistConrtoller::class, 'show']);
        Route::post('/delete', [TheraphistConrtoller::class, 'destroy']);
    });

    Route::post('/schedule', [AdminScheduleController::class, 'store']);
});
