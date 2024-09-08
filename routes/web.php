<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConsigneeController;

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index']);

// Client Routes
Route::get('/client', [ClientController::class, 'index']);

// Consignee Route
Route::get('/consignee', [ConsigneeController::class, 'index']);