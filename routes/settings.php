<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SettingUserController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
    Route::redirect('settings', '/settings/profile');

    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('settings/password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [PasswordController::class, 'update'])->name('password.update');

    Route::get('settings/appearance', function () {
        return Inertia::render('settings/Appearance');
    })->name('appearance');

    Route::get('settings/setting-user/data', [SettingUserController::class, 'datauser'])->name('setting-user.data');
});

Route::middleware('auth', isAdmin::class)->group(function () {
    Route::get('settings/setting-user', [SettingUserController::class, 'index'])->name('setting-user');
    Route::get('settings/setting-user/tambah', [SettingUserController::class, 'tambah'])->name('setting-user.tambah');
    Route::post('settings/setting-user/save', [SettingUserController::class, 'save'])->name('setting-user.save');
    Route::get('settings/setting-user/{id}/edit', [SettingUserController::class, 'edit'])->name('setting-user.edit');
    Route::patch('settings/setting-user/update', [SettingUserController::class, 'update'])->name('setting-user.update');
    Route::delete('settings/setting-user/{id}/delete', [SettingUserController::class, 'destroy'])->name('setting-user.destroy');
});
