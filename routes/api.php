<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

// Posts
Route::controller(PostController::class)->group(function () {
    Route::get('posts', 'index'); // Get all posts
    Route::get('posts/{post}', 'show'); // Get post by id
    Route::post('posts', 'store'); // Add a new post
    Route::put('posts/{post}', 'update'); // Update a post by id
    Route::delete('posts/{post}', 'destroy'); // Delete post by id
});

// Categories
Route::controller(CategoryController::class)->group(function () {
    Route::get('categories', 'index'); // Get all categories
    Route::post('categories', 'store'); // Add a new category
    Route::put('categories/{category}', 'update'); // Update a category by id
    Route::delete('categories/{category}', 'destroy'); // Delete a category by id
});

// Comments
Route::controller(CommentController::class)->group(function () {
    Route::get('posts/{post}/comments', 'index'); // Get all comments by post
    Route::post('posts/{post}/comments', 'store'); // Add a new comment
    Route::put('comments/{comment}', 'update'); // Update a comment by id
    Route::delete('comments/{comment}', 'destroy'); // Delete a comment by id
});

// Users
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register'); // Register a new user
    Route::post('login', 'login'); // Login a user
});
Route::controller(UserController::class)->group(function () {
    Route::get('user', 'index'); // Get user info
    Route::get('user/{user}', 'show'); // Get user info by id
    Route::put('user', 'update'); // Update user info
    Route::delete('user', 'destroy'); // Delete user
});


/* --------------------------------Middleware----------------------------------
 * Route for authenticated users only (using Sanctum middleware)
 */
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('user', UserController::class)->except(['show']);

    Route::resource('posts', PostController::class)->except(['index', 'show']);

    Route::resource('categories', CategoryController::class)->except(['index']);

    Route::resource('comments', CommentController::class);
    Route::resource('posts', CommentController::class)->except(['index']);
});
