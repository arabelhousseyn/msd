<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FolderController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/admin')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::resource('users', UserController::class);
        Route::resource('folders', FolderController::class);
        Route::post('/users/password-update/{user}', [UserController::class, 'updatePassword']);
        Route::get('/users/companies/{company}', [UserController::class, 'usersByCompany']);
    });
});
