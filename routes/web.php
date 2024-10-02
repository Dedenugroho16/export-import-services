<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsigneesController;
use App\Http\Controllers\CommoditiesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\UserController;

// Dashboard Routes (hanya bisa diakses jika sudah login)
Route::get('/', [DashboardController::class, 'index'])->name('home')->middleware('auth');

// Client Routes using resource
Route::resource('clients', ClientsController::class);
Route::get('clients', [ClientsController::class, 'index'])->name('clients.index');


// Use id_hash for client routes
Route::get('/clients/{hash}', [ClientsController::class, 'show'])->name('clients.show');
Route::get('/clients/{hash}/edit', [ClientsController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{hash}', [ClientsController::class, 'update'])->name('clients.update');
Route::get('clients/details/{hash}', [ClientsController::class, 'details'])->name('clients.details');


// Consignee Routes using resource
Route::resource('consignees', ConsigneesController::class);
Route::get('consignees/create/{hash}', [ConsigneesController::class, 'create'])->name('consignees.create');

// Product Routes using resource
Route::resource('products', ProductsController::class);

// Use id_hash for product routes
Route::get('products/{hash}/details', [ProductsController::class, 'showDetails'])->name('products.details');
Route::get('/products/{hash}/edit', [ProductsController::class, 'edit'])->name('products.edit');
Route::put('/products/{hash}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/{hash}', [ProductsController::class, 'destroy'])->name('products.destroy');

// Commodity Routes using resource
Route::resource('commodities', CommoditiesController::class);
Route::get('/commodities/{hash}', [CommoditiesController::class, 'show'])->name('commodities.show');
Route::get('/commodities/{hash}/edit', [CommoditiesController::class, 'edit'])->name('commodities.edit');
Route::put('/commodities/{hash}', [CommoditiesController::class, 'update'])->name('commodities.update');
Route::delete('/commodities/{hash}', [CommoditiesController::class, 'destroy'])->name('commodities.destroy');

// Detail Products Routes using resource
Route::resource('detail-products', DetailProductController::class);
Route::get('/detail-products/{hash}', [DetailProductController::class, 'show'])->name('detail-products.show');
Route::get('/detail-products/{hash}/edit', [DetailProductController::class, 'edit'])->name('detail-products.edit');
Route::put('/detail-products/{hash}', [DetailProductController::class, 'update'])->name('detail-products.update');
Route::delete('/detail-products/{hash}', [DetailProductController::class, 'destroy'])->name('detail-products.destroy');
Route::get('detail-products/create/{hash}', [DetailProductController::class, 'create'])->name('detail-products.create');


// Country Routes using resource
Route::resource('countries', CountryController::class);

// Branch Routes
Route::resource('branches', BranchController::class);

// Transaction Routes using resource
Route::resource('transaction', TransactionController::class);
// Get Consignees
Route::get('/get-consignees/{client_id}', [App\Http\Controllers\TransactionController::class, 'getConsignees']);
Route::get('/get-detail-products', [TransactionController::class, 'getDetailProducts'])->name('get-detail-products');

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Register Route (Hanya untuk tamu)
Route::view('/register', 'auth.register')->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');

// Login Routes (Hanya untuk tamu)
Route::view('/login', 'auth.login')->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');

Route::get('/data-user', [UserController::class, 'index'])->name('users.index');
Route::resource('users', UserController::class);