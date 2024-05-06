<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/admin')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('companies', CompanyController::class);
    });
});
