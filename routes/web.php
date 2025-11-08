<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmsController;

Route::get('/', function () {
    return view('home.index');
})->name('home');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1'); // 5 attempts per minute
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // 5 attempts per minute
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Logs routes (should be protected in production)
Route::middleware(['auth'])->group(function () {
    Route::get('/logs', [\App\Http\Controllers\LogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{fileName}/download', [\App\Http\Controllers\LogController::class, 'download'])->name('logs.download');
    Route::delete('/logs/{fileName}/clear', [\App\Http\Controllers\LogController::class, 'clear'])->name('logs.clear');
});

// CMS routes (protected - chỉ role ID 2-9 mới vào được)
Route::prefix('cms')->middleware(['auth', 'cms.access'])->name('cms.')->group(function () {
    Route::get('/dashboard', [CmsController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [CmsController::class, 'products'])->name('products');
    Route::get('/products/{id}', [CmsController::class, 'showProduct'])->name('products.show');
    Route::post('/products', [CmsController::class, 'storeProduct'])->name('products.store');
    Route::get('/categories', [CmsController::class, 'categories'])->name('categories');
    Route::post('/categories', [CmsController::class, 'storeCategory'])->name('categories.store');
    Route::get('/users', [CmsController::class, 'users'])->middleware('role:admin')->name('users');
});
