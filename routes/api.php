<?php

use App\Http\Controllers\API\Admin\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/admin',[AdminController::class,'hello']);


//USERS
Route::post('/user/add',[UserController::class,'store']);
Route::get('/users',[UserController::class,'show']);
