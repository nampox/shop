<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmsController;

Route::get('/', function () {
    return view('home.index');
})->name('home');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Logs routes (should be protected in production)
Route::middleware(['auth'])->group(function () {
    Route::get('/logs', [\App\Http\Controllers\LogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{fileName}/download', [\App\Http\Controllers\LogController::class, 'download'])->name('logs.download');
    Route::delete('/logs/{fileName}/clear', [\App\Http\Controllers\LogController::class, 'clear'])->name('logs.clear');
});

// CMS routes (protected)
Route::prefix('cms')->middleware(['auth'])->name('cms.')->group(function () {
    Route::get('/dashboard', [CmsController::class, 'dashboard'])->name('dashboard');
    Route::get('/posts', [CmsController::class, 'posts'])->name('posts');
    Route::get('/pages', [CmsController::class, 'pages'])->name('pages');
    Route::get('/media', [CmsController::class, 'media'])->name('media');
    Route::get('/users', [CmsController::class, 'users'])->name('users');
    Route::get('/settings', [CmsController::class, 'settings'])->name('settings');
});
