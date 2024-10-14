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
                        <i class="fas fa-users text-primary"></i> Clients
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                    <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
                </div>
            </div>

            <!-- Kartu untuk Produk -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-box text-success"></i> Products
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                    <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                    <a href="{{ url('/products') }}" class="btn btn-success btn-sm">Lihat Produk</a>
                </div>
            </div>

            <!-- Kartu untuk Komoditas -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-gem text-warning"></i> Commodities
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                    <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                    <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                </div>
            </div>

            <!-- Kartu untuk Negara -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-flag text-danger"></i> Countries
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                    <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                    <a href="{{ url('/countries') }}" class="btn btn-danger btn-sm">Lihat Negara</a>
                </div>
            </div>

            <!-- Kartu untuk Pengguna -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-user text-info"></i> Users
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $usersCount }}</span></p>
                    <p class="card-text text-muted">Kelola data pengguna di sini.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">Lihat Pengguna</a>
                </div>
            </div>

            <!-- Kartu untuk Cabang -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-building text-secondary"></i> Branches
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $branchesCount }}</span></p>
                    <p class="card-text text-muted">Kelola data cabang di sini.</p>
                    <a href="{{ route('branches.index') }}" class="btn btn-secondary btn-sm">Lihat Cabang</a>
                </div>
            </div>

            <!-- Kartu untuk Data Perusahaan -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-building text-info"></i> Company Data
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $companyCount }}</span></p>
                    <p class="card-text text-muted">Kelola data perusahaan Anda di sini.</p>
                    <a href="{{ route('company.index')}}" class="btn btn-info btn-sm">Lihat Data Perusahaan</a>
                </div>
            </div>

            <!-- Kartu untuk Transaksi -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-receipt text-warning"></i> Transactions
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                    <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                    <a href="{{ route('proforma.create') }}" class="btn btn-warning btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        @elseif(auth()->user()->role === 'operator')
        <!-- Kartu untuk Client -->
        <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-users text-primary"></i> Clients
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                    <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
                </div>
            </div>

            <!-- Kartu untuk Produk -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-box text-success"></i> Products
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                    <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                    <a href="{{ url('/products') }}" class="btn btn-success btn-sm">Lihat Produk</a>
                </div>
            </div>

            <!-- Kartu untuk Komoditas -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-gem text-warning"></i> Commodities
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                    <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                    <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                </div>
            </div>

            <!-- Kartu untuk Negara -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-flag text-danger"></i> Countries
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                    <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                    <a href="{{ url('/countries') }}" class="btn btn-danger btn-sm">Lihat Negara</a>
                </div>
            </div>

            <div class="card border-light shadow-sm full-width">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-receipt text-warning"></i> Transactions
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                    <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                    <a href="{{ route('proforma.create') }}" class="btn btn-warning btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        @elseif(auth()->user()->role === 'director')
            <div class="card border-light shadow-sm full-width">
                <div class="card-body text-center">
                     <h6 class="card-title">
                        <i class="fas fa-receipt text-warning"></i> Transactions
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                    <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                    <a href="{{ route('proforma.create') }}" class="btn btn-warning btn-sm">Lihat Transaksi</a>
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
        background-color: #ffffff; /* Warna latar belakang yang lebih bersih */
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn {
        border-radius: 5px;
        font-size: 0.9rem; /* Ukuran font tombol */
    }

    .full-width {
        grid-column: span 4; /* Atur kartu transaksi agar mengambil seluruh kolom di grid */
        width: 100%; /* Pastikan lebar penuh */
    }
</style>

@endsection
