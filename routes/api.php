<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SemesterController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/roles',[RoleController::class, 'rolesForRegister']);
Route::get('/learners', [UserController::class, 'learnersList']);
Route::get('/instructors', [UserController::class, 'instructorsList']);

Route::get('/semesters', [SemesterController::class, 'index']);
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/users', [UserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function() {
    // Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/create', [UserController::class, 'create']);
    Route::get('/users/{id}/read', [UserController::class, 'read']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::post('/users/{id}/update', [UserController::class, 'update']);
    Route::post('/users/{id}/delete', [UserController::class, 'delete']);
    Route::post('/users/{id}/approve', [UserController::class, 'isApproved']);
    Route::post('/users/{id}/approve-pending', [UserController::class, 'approvePending']);

    Route::post('/semesters/create', [SemesterController::class, 'create']);
    Route::get('/semesters/{id}/read', [SemesterController::class, 'read']);
    Route::get('/semesters/{id}/edit', [SemesterController::class, 'edit']);
    Route::post('/semesters/{id}/update', [SemesterController::class, 'update']);
    Route::post('/semesters/{id}/delete', [SemesterController::class, 'delete']);

    Route::post('/courses/create', [CourseController::class, 'create']);
    Route::get('/courses/{id}/read', [CourseController::class, 'read']);
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit']);
    Route::post('/courses/{id}/update', [CourseController::class, 'update']);
    Route::post('/courses/{id}/delete', [CourseController::class, 'delete']);
});
