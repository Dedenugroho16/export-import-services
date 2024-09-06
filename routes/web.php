<?php

use Illuminate\Support\Facades\Route;

// Rute untuk halaman dashboard
Route::get('/', function () {
    return view('dashboard');
});

// Rute untuk halaman clients
Route::get('/clients', function () {
    return view('clients');
});
