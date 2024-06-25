<?php

use App\Http\Controllers\Admin\InstallerController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FolderController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PerformanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1/admin')->group(function () {


    Route::get('/installer', [InstallerController::class, 'index']);
    Route::post('/installer', [InstallerController::class, 'store']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::resource('companies', CompanyController::class);
        Route::resource('users', UserController::class);
        Route::resource('folders', FolderController::class);
        Route::resource('documents', DocumentController::class);
        Route::resource('roles', RoleController::class);
        Route::get('permissions', PermissionController::class);
        Route::get('/performance', PerformanceController::class);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/users/password-update/{user}', [UserController::class, 'updatePassword']);
        Route::post('/update', [AuthController::class, 'update']);
        Route::post('/password-update', [AuthController::class, 'updatePassword']);
        Route::post('/store-comment/{folder}', [FolderController::class, 'storeComment']);
        Route::delete('/folders/delete/{folder}', [FolderController::class, 'forceDestroy']);
        Route::get('/users/{user}/notifications', [UserController::class, 'notifications']);
    });
});
