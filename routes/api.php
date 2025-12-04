<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


//Auth;
Route::post('/reg', [UserController::class, 'registration'])->name('registration');
Route::post('/login', [UserController::class, 'login'])->name('login');


//Category
Route::get('/category/get_all', [CategoryController::class, 'get_all'])->name('category_get_all'); 

//Account
Route::get('/account/get_all', [AccountController::class, 'get_all'])->name('account_get_all'); 
Route::post('/account/create', [AccountController::class, 'create'])->name('account_create');
Route::put('/account/update', [AccountController::class, 'update'])->name('account_update');

