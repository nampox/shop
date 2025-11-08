<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmsController;

Route::get('/', function () {
    return view('home.index');
})->name('home');

// Authentication routes
Route::prefix('register')->name('register')->group(function () {
    Route::get('/', [AuthController::class, 'showRegistrationForm']);
    Route::post('/', [AuthController::class, 'register'])->middleware('throttle:5,1'); // 5 attempts per minute
});

Route::prefix('login')->name('login')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm']);
    Route::post('/', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Logs (should be protected in production)
Route::middleware(['auth'])->group(function () {
    Route::get('/logs', [\App\Http\Controllers\LogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{fileName}/download', [\App\Http\Controllers\LogController::class, 'download'])->name('logs.download');
    Route::delete('/logs/{fileName}/clear', [\App\Http\Controllers\LogController::class, 'clear'])->name('logs.clear');
});

// CMS (protected - chỉ role ID 2-9 mới vào được)
Route::prefix('cms')->middleware(['auth', 'cms.access'])->name('cms.')->group(function () {
    Route::get('/dashboard', [CmsController::class, 'dashboard'])->name('dashboard');
    
    // Products
    Route::prefix('products')->name('products')->group(function () {
        Route::get('/', [CmsController::class, 'products']);
        Route::get('/{id}', [CmsController::class, 'showProduct'])->name('.show');
        Route::post('/', [CmsController::class, 'storeProduct'])->name('.store');
    });
    
    // Categories
    Route::prefix('categories')->name('categories')->group(function () {
        Route::get('/', [CmsController::class, 'categories']);
        Route::post('/', [CmsController::class, 'storeCategory'])->name('.store');
    });
    
    Route::get('/users', [CmsController::class, 'users'])->middleware('role:admin')->name('users');
});
