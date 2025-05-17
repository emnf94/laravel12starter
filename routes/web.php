<?php

use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage', ['appName' => env('APP_NAME', 'YourApp')]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('setting-user', function () {
    return Inertia::render('SettingUser');
})->middleware(['auth', 'verified', isAdmin::class])->name('setting-user');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
