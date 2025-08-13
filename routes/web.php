<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);
Route::get('/user-list', [UserController::class, 'userList'])->name('user.userList');
Route::post('/users', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{encryptedId}', [UserController::class, 'edit']);
Route::post('/users/{encryptedId}', [UserController::class, 'toggleStatus'])->name('user.toggleStatus');

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/category-list', [CategoryController::class, 'categoryList'])->name('category.categoryList');
Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
Route::get('/categories/{encryptedId}', [CategoryController::class, 'edit']);
