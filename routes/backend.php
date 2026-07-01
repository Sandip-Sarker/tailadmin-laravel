<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DynamicPageController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Page Settings Route
    Route::get('/page-setting', [DynamicPageController::class, 'index'])->name('page-setting');
    Route::get('/page-setting/{id}/edit', [DynamicPageController::class, 'edit'])->name('page-setting.edit');
    Route::post('/page-setting/{id}/update', [DynamicPageController::class, 'update'])->name('page-setting.update');

    // User Route
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [UserController::class, 'update'])->name('update');
        Route::post('/{id}/delete', [UserController::class, 'destroy'])->name('destroy');
    });
}); 