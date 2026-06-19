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
// Throttle the public form to curb spam / mail-bombing of the admin inbox (and Mailgun cost).
Route::post('/contact/create', [CustomerInformationController::class, 'create'])
    ->middleware('throttle:5,1')
    ->name('customerInformationCreate');
Route::get('/complaints', [CustomerInformationController::class, 'complaints'])->name('complaints')->middleware('auth');


Route::get('/signin', [AuthController::class, 'showRegister']);
Route::get('/login', [AuthController::class, 'showLogin']);
// Throttle auth endpoints to prevent password brute-force / registration abuse.
Route::post('/signin', [AuthController::class, 'register'])->middleware('throttle:5,1')->name('signin');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
