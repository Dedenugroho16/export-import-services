@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <div class="grid-container">
        @if(auth()->user()->role === 'admin')
            <!-- Kartu untuk Client -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-users" style="color: #007bff;"></i> Clients
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                    <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm" style="background-color: #007bff; border-color: #007bff;">Lihat Client</a>
                </div>
            </div>

            <!-- Kartu untuk Produk -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-box" style="color: #28a745;"></i> Products
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                    <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                    <a href="{{ url('/products') }}" class="btn btn-success btn-sm" style="background-color: #28a745; border-color: #28a745;">Lihat Produk</a>
                </div>
            </div>

            <!-- Kartu untuk Komoditas -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-gem" style="color: #ffc107;"></i> Commodities
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                    <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                    <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm" style="background-color: #ffc107; border-color: #ffc107;">Lihat Komoditas</a>
                </div>
            </div>

            <!-- Kartu untuk Negara -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-flag" style="color: #dc3545;"></i> Countries
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                    <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                    <a href="{{ url('/countries') }}" class="btn btn-danger btn-sm" style="background-color: #dc3545; border-color: #dc3545;">Lihat Negara</a>
                </div>
            </div>

            <!-- Kartu untuk Pengguna -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-user" style="color: #17a2b8;"></i> Users
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $usersCount }}</span></p>
                    <p class="card-text text-muted">Kelola data pengguna di sini.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-info btn-sm" style="background-color: #17a2b8; border-color: #17a2b8;">Lihat Pengguna</a>
                </div>
            </div>

            <!-- Kartu untuk Data Perusahaan -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-building" style="color: #6f42c1;"></i> Company Data
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $companyCount }}</span></p>
                    <p class="card-text text-muted">Kelola data perusahaan Anda di sini.</p>
                    <a href="{{ route('company.index') }}" class="btn btn-secondary btn-sm" style="background-color: #6f42c1; border-color: #6f42c1;">Lihat Data Perusahaan</a>
                </div>
            </div>

            <!-- Kartu untuk Transaksi -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-receipt" style="color: #e83e8c;"></i> Transactions
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                    <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                    <a href="{{ route('proforma.create') }}" class="btn btn-pink btn-sm" style="background-color: #e83e8c; border-color: #e83e8c;">Lihat Transaksi</a>
                </div>
            </div>

            <!-- Kartu untuk Rekap Penjualan -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-chart-line" style="color: #6610f2;"></i> Sales Recap
                    </h6>
                    <p class="card-text">Total Penjualan: <span class="font-weight-bold">#</span></p>
                    <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                    <a href="{{ route('transactions.rekap') }}" class="btn btn-purple btn-sm" style="background-color: #6610f2; border-color: #6610f2;">Lihat Rekap</a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 16px;
    }

    .card {
        border-radius: 10px;
        transition: transform 0.2s, box-shadow 0.2s;
        background-color: #ffffff;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn {
        border-radius: 5px;
        font-size: 0.9rem;
    }
</style>
@endsection
