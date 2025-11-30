<?php

use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');



Route::get('admin/login', [AdminAuthController::class, 'admin_login'])->name('admin.login');
Route::post('admin/login/submit', [AdminAuthController::class, 'admin_login_submit'])->name('admin.login.submit');
Route::post('admin/logout', [AdminAuthController::class, 'admin_logout'])->name('admin.logout');




Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'admin'])->name('admin.dashboard');
});

