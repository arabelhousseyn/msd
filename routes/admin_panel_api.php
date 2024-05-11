<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FolderController;
use App\Http\Controllers\Admin\DocumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/admin')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::resource('users', UserController::class);
        Route::resource('folders', FolderController::class);
        Route::resource('documents', DocumentController::class);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/users/password-update/{user}', [UserController::class, 'updatePassword']);
        Route::post('/update', [AuthController::class, 'update']);
        Route::post('/password-update', [AuthController::class, 'updatePassword']);
        Route::get('/users/{user}/notifications', [UserController::class, 'notifications']);
    });
});
