<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/roles', [RoleController::class, 'rolesForRegister']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'create']);
    Route::get('/users/{id}/read', [UserController::class, 'read']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::post('/users/{id}/update', [UserController::class, 'update']);
    Route::post('/users/{id}/delete', [UserController::class, 'delete']);
    Route::post('/users/{id}/isApproved', [UserController::class, 'isApproved']);
    Route::post('/users/{id}/pendingApproved', [UserController::class, 'pendingApproved']);
});
