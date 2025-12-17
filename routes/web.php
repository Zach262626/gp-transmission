<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerInformationController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/complaints', [CustomerInformationController::class, 'complaints'])->name('complaints');

    // Add more protected routes here
});

Route::view('/', 'main')->name('main');
Route::view('/testing', 'testing')->name('testing');



Route::get('/login', function () {
    return view('login');
});
Route::get('/signin', function () {
    return view('signin');
});

Route::view('/contact', 'contact')->name('contact');
Route::post('/contact/create', [CustomerInformationController::class, 'create'])->name('customerInformationCreate');


Route::get('/signin', [AuthController::class, 'showRegister']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/signin', [AuthController::class, 'register'])->name('signin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
