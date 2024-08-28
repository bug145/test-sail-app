<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

/* --------------------------------Public Routes (Без аутентификации) -------------------------- */

// User Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login')->name('login');
});

// Public Post Routes
Route::get('posts', [PostController::class, 'index']);
Route::get('posts/{post}', [PostController::class, 'show']);

// Public User Routes
Route::get('user/{user}', [UserController::class, 'show']);

// Public Category Routes
Route::get('categories', [CategoryController::class, 'index']);

// Public Comment Routes
Route::get('posts/{post}/comments', [CommentController::class, 'index']);



/* --------------------------------Authenticated Routes (Требуется аутентификация) -------------------------- */

Route::middleware('auth:sanctum')->group(function () {
    // User Management Routes
    Route::get('user', [UserController::class, 'index']);
    Route::put('user', [UserController::class, 'update']);
    Route::delete('user', [UserController::class, 'destroy']);

    // Post Management Routes
    Route::post('posts', [PostController::class, 'store']);
    Route::put('posts/{post}', [PostController::class, 'update']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);

    // Category Management Routes
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Comment Management Routes
    Route::post('posts/{post}/comments', [CommentController::class, 'store']);
    Route::put('comments/{comment}', [CommentController::class, 'update']);
    Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
});
