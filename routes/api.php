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
Route::resource('posts', PostController::class)->only(['index', 'show']);

// Public User Routes
Route::get('user/{user}', [UserController::class, 'show']);

// Public Category Routes
Route::resource('categories', CategoryController::class)->only(['index']);

// Public Comment Routes
Route::get('posts/{post}/comments', [CommentController::class, 'index']);


/* --------------------------------Authenticated Routes (Требуется аутентификация) -------------------------- */

Route::middleware('auth:sanctum')->group(function () {
    // User Management Routes
    Route::controller(UserController::class)->group(function () {
        Route::get('user', 'index'); // Get user info
        Route::post('user', 'update'); // Update user info
        Route::delete('user', 'destroy'); // Delete user
    });

    // Post Management Routes
    Route::resource('posts', PostController::class)->except(['index', 'show']);

    // Category Management Routes
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);

    // Comment Management Routes
    Route::resource('comments', CommentController::class)->except(['index', 'show']);
});
