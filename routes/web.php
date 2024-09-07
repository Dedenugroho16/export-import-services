<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index']);

// Client Routes
Route::get('/client', [ClientController::class, 'index']);