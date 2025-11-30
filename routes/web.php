<?php

use App\Http\Controllers\Backend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [FrontendController::class, 'frontend'])->name('frontend');
