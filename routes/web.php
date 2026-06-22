<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerInformationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/complaints', [CustomerInformationController::class, 'complaints'])->name('complaints');

    // Add more protected routes here
});

Route::view('/', 'main')->name('main');
Route::view('/services', 'services')->name('services');
Route::view('/about', 'about')->name('about');
Route::view('/testing', 'testing')->name('testing');

// SEO: dynamic robots.txt + sitemap so the Sitemap URL is correct on any host.
Route::get('/robots.txt', function () {
    $lines = [
        'User-agent: *',
        'Disallow: /telescope',
        'Disallow: /complaints',
        'Disallow: /login',
        'Disallow: /signin',
        'Disallow: /testing',
        '',
        'Sitemap: '.url('/sitemap.xml'),
        '',
    ];

    return response(implode("\n", $lines), 200)
        ->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', function () {
    $urls = ['/', '/services', '/about', '/contact'];
    $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
    foreach ($urls as $path) {
        $xml .= '  <url><loc>'.e(url($path)).'</loc></url>'."\n";
    }
    $xml .= '</urlset>'."\n";

    return response($xml, 200)->header('Content-Type', 'application/xml');
});

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
