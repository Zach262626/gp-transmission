<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::view('/', 'main')->name('main');


Route::get('/login', function () {
    return view('login');
});
Route::get('/signin', function () {
    return view('signin');
});

Route::post('/signin', [AuthController::class, 'register'])->name('signin');
Route::post('/login', [AuthController::class, 'login'])->name('login');