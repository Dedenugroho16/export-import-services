<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProformaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConsigneesController;
use App\Http\Controllers\CommoditiesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DetailProductController;
use App\Http\Controllers\ProformaInvoiceController;
use App\Http\Controllers\DetailTransactionController;

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
// Route::resource('transaction', TransactionController::class);
Route::get('/get-invoice', [TransactionController::class, 'getInvoice'])->name('getInvoice');
Route::get('transaction', [TransactionController::class, 'index'])->name('transaction.index');
Route::get('transaction/create/{id}', [TransactionController::class, 'create'])->name('transaction.create');
Route::get('/transaction/{hashId}', [TransactionController::class, 'show'])->name('transaction.show');
// Route untuk update transaksi
Route::put('/transaction/update/{id}', [TransactionController::class, 'update'])->name('transaction.update');

// Route untuk delete detail transaction
Route::delete('/detail-transaction/delete/{id_detail_product}', [DetailTransactionController::class, 'destroy'])->name('detail-transaction.delete');

// Route Packing List
Route::get('/packing-list/{hashId}', [TransactionController::class, 'packingListShow'])->name('packingList.show');

// Proforma invoice route
Route::get('proforma', [ProformaController::class, 'index'])->name('proforma.index');
Route::get('proforma/create', [ProformaController::class, 'create'])->name('proforma.create');
Route::post('/proforma/store', [ProformaController::class, 'store'])->name('proforma.store');
Route::get('/proforma/show/{id}', [ProformaController::class, 'show'])->name('proforma.show');
Route::get('/proforma/edit/{hash}', [ProformaController::class, 'edit'])->name('proforma.edit');
Route::get('proforma/data', [ProformaController::class, 'getProformaData'])->name('proforma.data');
Route::get('/approved-proforma/data', [ProformaController::class, 'getApprovedData'])->name('approved.data');
Route::get('/get-detail-transaction/{idTransaction}', [ProformaController::class, 'getDetailTransaction'])->name('get-detail-transaction');
// fungsi untuk mengecek detail transaction dari transaction untuk mencegah memilih detail produk lebih dari 1x
// Route untuk mendapatkan selectedProductIds dengan ID transaksi
Route::get('/get-selected-product-ids/{id}', [ProformaController::class, 'getSelectedProductIds']);

// APPROVE
Route::post('proforma/approve/{id}', [ProformaController::class, 'approveProforma'])->name('proforma.approve');

// Get Consignees
Route::get('/get-consignees/{client_id}', [App\Http\Controllers\TransactionController::class, 'getConsignees']);
Route::get('/get-detail-products', [TransactionController::class, 'getDetailProducts'])->name('get-detail-products');
Route::get('/edit-get-detail-products', [ProformaController::class, 'editGetDetailProducts'])->name('edit-get-detail-products');

// Detail Transaction Route
Route::post('/detailtransaction/store', [DetailTransactionController::class, 'store'])->name('detailtransaction.store');

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

Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show')->middleware('auth');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');