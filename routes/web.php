<?php

use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CommissionSettingController;
use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\FrontendDashboardController;
use App\Models\CommissionSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

// Frontend Routes

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');


Route::get('frontend/login', [FrontendAuthController::class, 'frontend_login'])->name('frontend.login');

Route::post('frontend/login/submit', [FrontendAuthController::class, 'frontend_login_submit'])->name('frontend.login.submit');

Route::post('frontend/logout', [FrontendAuthController::class, 'frontend_logout'])->name('frontend.logout');
Route::get('frontend/register', [FrontendAuthController::class, 'frontend_register'])->name('frontend.register');
Route::get('frontend/register', [FrontendAuthController::class, 'frontend_register'])->name('frontend.register');
Route::post('frontend/register/submit', [FrontendAuthController::class, 'frontend_register_submit'])->name('frontend.register.submit');

// Protect Dashboard (login required)
Route::middleware(['user'])->group(function () {
    Route::get('frontend/dashboard', [FrontendDashboardController::class, 'frontend'])->name('frontend.dashboard');
});


// End Frontend Routes




// Admin Auth Routes
Route::get('admin/login', [AdminAuthController::class, 'admin_login'])->name('admin.login');
Route::post('admin/login/submit', [AdminAuthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::post('admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin.logout');





Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'admin'])->name('admin.dashboard');
    Route::resource('commissionsetting', CommissionSettingController::class);
});
// End Admin Auth Routes

