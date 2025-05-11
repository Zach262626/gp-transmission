<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;

Route::get('/', function () {
    return view('main');
});

Route::get('/test', function () {
    return view('layouts.footers.footer');
});

Route::get('/login', function () {
    return view('login');
});
Route::get('/signin', function () {
    return view('signin');
});
