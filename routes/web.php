<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ConsigneeController;

// Dashboard Routes
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Client Routes
Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index'); // Index
Route::get('/clients/create', [ClientsController::class, 'create'])->name('clients.create'); // Create
Route::post('/clients', [ClientsController::class, 'store'])->name('clients.store'); // Store
Route::get('/clients/{id}', [ClientsController::class, 'show'])->name('clients.show')->where('id', '[0-9]+'); // Show
Route::get('/clients/{id}/edit', [ClientsController::class, 'edit'])->name('clients.edit')->where('id', '[0-9]+'); // Edit
Route::put('/clients/{id}', [ClientsController::class, 'update'])->name('clients.update')->where('id', '[0-9]+'); // Update
Route::delete('/clients/{id}', [ClientsController::class, 'destroy'])->name('clients.destroy')->where('id', '[0-9]+'); // Destroy

// Consignee Route
Route::get('/consignee', [ConsigneeController::class, 'index']);
