<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::view('/', 'main')->name('main');
Route::view('/contact', 'contact')->name('contact');


Route::get('/login', function () {
    return view('login');
});
Route::get('/signin', function () {
    return view('signin');
});
Route::get('/signin', [AuthController::class, 'showRegister']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/signin', [AuthController::class, 'register'])->name('signin');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');;