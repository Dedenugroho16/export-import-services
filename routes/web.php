<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsigneesController;
use App\Http\Controllers\CommoditiesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailProductController;

// Dashboard Routes (hanya bisa diakses jika sudah login)
Route::get('/', [DashboardController::class, 'index'])->name('home')->middleware('auth');

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
Route::resource('countries', CountryController::class);

// Transaction Route
Route::resource('transaction', TransactionController::class);
// Get Consignees
Route::get('/get-consignees/{clientId}', [TransactionController::class, 'getConsignees']);

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register Route (Hanya untuk tamu)
Route::view('/register', 'auth.register')->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login Routes (Hanya untuk tamu)
Route::view('/login', 'auth.login')->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');