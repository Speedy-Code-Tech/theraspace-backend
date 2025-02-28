<?php

use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChildrenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/admin',[AdminController::class,'hello']);
Route::get('/test',[AdminController::class,'hello']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

Route::prefix('child')->middleware('auth:sanctum')->group(function () {
    Route::post('/add', [ChildrenController::class, 'store']);
    Route::get('/{id}', [ChildrenController::class, 'show']);
    Route::post('/delete', [ChildrenController::class, 'destroy']);
});