<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


//Route::post('reg', 'UserController@registration');
Route::post('/reg', [UserController::class, 'registration'])->name('registration');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/category/get_all', [CategoryController::class, 'get_all'])->name('category_get_all'); 

