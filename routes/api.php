<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->name('user.')->prefix('auth')->group(function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update'])
        ->middleware('auth:sanctum');
    Route::delete('/{id}', [UserController::class, 'destroy'])
        ->name('delete')->middleware('auth:sanctum');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout')->middleware('auth:sanctum');
});

Route::namespace('Api')->middleware('auth:sanctum')->name('property.')->prefix('property')->group(function () {

    Route::get('/', [PropertyController::class, 'index'])
        ->name('list');
    Route::get('/{id}', [PropertyController::class, 'show'])
        ->name('show');
    Route::post('/', [PropertyController::class, 'store'])
        ->name('create');
    Route::put('/{id}', [PropertyController::class, 'update'])
        ->name('update');
    Route::delete('/{id}', [PropertyController::class, 'destroy'])
        ->name('delete');
});
