<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TreeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\BinaryTreeController;
use App\Http\Controllers\PermissionController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/roles',[RoleController::class, 'index']);
Route::get('/register-roles',[RoleController::class, 'rolesForRegister']);
Route::get('/learners', [UserController::class, 'learnersList']);
Route::get('/instructors', [UserController::class, 'instructorsList']);

Route::get('/semesters', [SemesterController::class, 'index']);
Route::get('/courses', [CourseController::class, 'index']);

Route::post('/search', [SearchController::class, 'search']);

Route::post('/binary-tree', [BinaryTreeController::class, 'generateTree']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/auth-users', [UserController::class, 'authUser']);
    Route::post('/users/create', [UserController::class, 'create']);
    Route::get('/users/{id}/read', [UserController::class, 'read']);
    Route::get('/users/{id}/edit', [UserController::class, 'edit']);
    Route::post('/users/{id}/update', [UserController::class, 'update']);
    Route::post('/users/{id}/delete', [UserController::class, 'delete']);
    Route::post('/users/{id}/approve', [UserController::class, 'isApproved']);
    Route::post('/users/{id}/approve-pending', [UserController::class, 'approvePending']);

    Route::post('/learners/create', [UserController::class, 'learnersCreate']);
    Route::post('/instructors/create', [UserController::class, 'instructorsCreate']);

    Route::post('/semesters/create', [SemesterController::class, 'create']);
    Route::get('/semesters/{id}/read', [SemesterController::class, 'read']);
    Route::get('/semesters/{id}/edit', [SemesterController::class, 'edit']);
    Route::post('/semesters/{id}/update', [SemesterController::class, 'update']);
    Route::post('/semesters/{id}/delete', [SemesterController::class, 'delete']);
    Route::get('/semesters/ongoing', [SemesterController::class, 'getOngoingSemester']);
    Route::get('/semesters/completed', [SemesterController::class, 'completedSemester']);

    Route::post('/courses/create', [CourseController::class, 'create']);
    Route::get('/courses/{id}/read', [CourseController::class, 'read']);
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit']);
    Route::post('/courses/{id}/update', [CourseController::class, 'update']);
    Route::post('/courses/{id}/delete', [CourseController::class, 'delete']);

    Route::post('/roles/create', [RoleController::class, 'create']);
    Route::get('/roles/{id}/read', [RoleController::class, 'read']);
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit']);
    Route::post('/roles/{id}/update', [RoleController::class, 'update']);
    Route::post('/roles/{id}/delete', [RoleController::class, 'delete']);

    Route::get('/roles-permissions', [PermissionController::class, 'index']);
    Route::post('/roles-permissions/update', [PermissionController::class, 'updatePermission']);

});
