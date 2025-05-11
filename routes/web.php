<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('main');
});

Route::get('/test', function () {
    return view('layouts.footers.footer');
});

Route::get('/login', function () {
    return view('login');
});
