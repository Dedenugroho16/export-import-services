<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CommoditiesController;
use App\Http\Controllers\ConsigneesController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\ProductsController;

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Client Routes using resource
Route::resource('clients', ClientsController::class);

// Consignee Routes using resource
Route::resource('consignees', ConsigneesController::class);

// Product Route
Route::resource('products', ProductsController::class);

// Commodity Route
Route::resource('commodities', CommoditiesController::class);

// Detail Products Route
Route::resource('detail-products', DetailProductController::class);

// Country Route
Route::get('/countries', [CountryController::class, 'index']);
