<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController; 


Route::post('/login', [AuthController::class, 'login']);


// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customers',[\App\Http\Controllers\API\CustomerController::class, 'list'])->name('customers.index');
     Route::get('/customers/ids', [\App\Http\Controllers\API\CustomerController::class, 'listIds'])->name('customers.ids');

     Route::get('/staff', [\App\Http\Controllers\API\StaffController::class, 'list']);
    Route::get('/staff/{id}', [\App\Http\Controllers\API\StaffController::class, 'show']);

    // Menu Items
    Route::get('/menuitems', [\App\Http\Controllers\API\MenuItemController::class, 'list']);
    Route::get('/menuitems/{id}', [\App\Http\Controllers\API\MenuItemController::class, 'show']);

    // Tables
    Route::get('/tables', [\App\Http\Controllers\API\TableController::class, 'list']);
    Route::get('/tables/{id}', [\App\Http\Controllers\API\TableController::class, 'show']);
});
