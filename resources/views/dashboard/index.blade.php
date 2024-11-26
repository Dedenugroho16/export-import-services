@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <div class="grid-container">
        <div class="d-flex flex-wrap justify-content-center">
            @if(auth()->user()->role === 'admin')
                <!-- Kartu untuk Client -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-users" style="color: #007bff;"></i> Clients
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
                    </div>
                </div>
                <!-- Kartu untuk Produk -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-cogs" style="color: #003161;"></i> Products
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                        <a href="{{ url('/products') }}" class="btn btn-info btn-sm" style="background-color: #003161; color: white;">Lihat Produk</a>
                    </div>
                </div>
                <!-- Kartu untuk Komoditas -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-donate" style="color: #ffc107;"></i> Commodities
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                        <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                        <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                    </div>
                </div>
                <!-- Kartu untuk Negara -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-flag" style="color: #28a745;"></i> Countries
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                        <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                        <a href="{{ url('/countries') }}" class="btn btn-success btn-sm">Lihat Negara</a>
                    </div>
                </div>
                <!-- Kartu untuk Pengguna -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-users-cog" style="color: #6f42c1;"></i> Users
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $usersCount }}</span></p>
                        <p class="card-text text-muted">Kelola data pengguna di sini.</p>
                        <a href="{{ route('users.index') }}" class="btn btn-purple btn-sm">Lihat Pengguna</a>
                    </div>
                </div>
                <!-- Kartu untuk Data Perusahaan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-building" style="color: #C62E2E;"></i> Company Data
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $companyCount }}</span></p>
                        <p class="card-text text-muted">Kelola data perusahaan Anda di sini.</p>
                        <a href="{{ route('company.index') }}" class="btn btn-danger btn-sm" style="background-color: #C62E2E; color: white;">Lihat Data Perusahaan</a>
                    </div>
                </div>
                <!-- Kartu untuk Transaksi -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-exchange-alt" style="color: #185519;"></i> Transactions
                            <!-- Dropdown Button (three dots icon) -->
                            <div class="dropdown d-inline float-end">
                                <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v" style="color: #185519;"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('proforma.index') }}">Proforma Invoices</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/incomplete-invoice') }}">Uncorfimed Invoices</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/transaction') }}">Final Invoice</a></li>
                                    <!-- Add more menu items as needed -->
                                </ul>
                            </div>
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                        <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                        <a href="{{ route('proforma.create') }}" class="btn btn-primary btn-sm" style="background-color: #185519; color: white;">Lihat Transaksi</a>
                    </div>
                </div>

                <!-- Kartu untuk Rekap Penjualan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-line" style="color: #914F1E;"></i> Sales Recap
                        </h6>
                        <p class="card-text">Total Penjualan: <span class="font-weight-bold">{{ $totalSales }}</span></p>
                        <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                        <a href="{{ route('transactions.rekap') }}" class="btn btn-warning btn-sm" style="background-color: #914F1E; color: white;">Lihat Rekap</a>
                    </div>
                </div>
                <!-- Kartu untuk Bill of Payments -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-file-invoice-dollar" style="color: #E90074;"></i> Bill of Payments
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $billsCount }}</span></p>
                        <p class="card-text text-muted">Lihat rekap pembayaran Anda di sini.</p>
                        <a href="{{ route('bill-of-payment.index') }}" class="btn btn-danger btn-sm" style="background-color: #E90074; color: white;">Lihat Rekap</a>
                    </div>
                </div>
                <!-- Kartu untuk Report -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-pie" style="color: #373A40;"></i> Report
                        </h6>
                        <p class="card-text">Total Penjualan: <span class="font-weight-bold"></span></p>
                        <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                        <a href="{{ route('transactions.AccountStatement') }}" class="btn btn-info btn-sm" style="background-color: #373A40; color: white;">Lihat Rekap</a>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'operator')
                <!-- Kartu untuk Client -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-users" style="color: #007bff;"></i> Clients
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $clientsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data client Anda di sini.</p>
                        <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
                    </div>
                </div>
                <!-- Kartu untuk Produk -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-cogs" style="color: #003161;"></i> Products
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $productsCount }}</span></p>
                        <p class="card-text text-muted">Kelola data produk Anda di sini.</p>
                        <a href="{{ url('/products') }}" class="btn btn-info btn-sm" style="background-color: #003161; color: white;">Lihat Produk</a>
                    </div>
                </div>
                <!-- Kartu untuk Komoditas -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-donate" style="color: #ffc107;"></i> Commodities
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $commoditiesCount }}</span></p>
                        <p class="card-text text-muted">Kelola data komoditas Anda di sini.</p>
                        <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                    </div>
                </div>
                <!-- Kartu untuk Negara -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-flag" style="color: #28a745;"></i> Countries
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $countriesCount }}</span></p>
                        <p class="card-text text-muted">Kelola informasi negara di sini.</p>
                        <a href="{{ url('/countries') }}" class="btn btn-success btn-sm">Lihat Negara</a>
                    </div>
                </div>
                <!-- Kartu untuk Transaksi -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-exchange-alt" style="color: #185519;"></i> Transactions
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                        <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                        <a href="{{ route('proforma.create') }}" class="btn btn-primary btn-sm" style="background-color: #185519; color: white;">Lihat Transaksi</a>
                    </div>
                </div>
                <!-- Kartu untuk Rekap Penjualan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-chart-line" style="color: #914F1E;"></i> Sales Recap
                        </h6>
                        <p class="card-text">Total Penjualan: <span class="font-weight-bold">{{ $totalSales }}</span></p>
                        <p class="card-text text-muted">Lihat rekap penjualan Anda di sini.</p>
                        <a href="{{ route('transactions.rekap') }}" class="btn btn-warning btn-sm" style="background-color: #914F1E; color: white;">Lihat Rekap</a>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'director')
                <!-- Kartu untuk Transaksi -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-exchange-alt" style="color: #185519;"></i> Transactions
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                        <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                        <a href="{{ route('proforma.create') }}" class="btn btn-primary btn-sm" style="background-color: #185519; color: white;">Lihat Transaksi</a>
                    </div>
                </div>
                <!-- Kartu untuk Data Perusahaan -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-building" style="color: #C62E2E;"></i> Company Data
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $companyCount }}</span></p>
                        <p class="card-text text-muted">Kelola data perusahaan Anda di sini.</p>
                        <a href="{{ route('company.index') }}" class="btn btn-danger btn-sm" style="background-color: #C62E2E; color: white;">Lihat Data Perusahaan</a>
                    </div>
                </div>
            @elseif(auth()->user()->role === 'finance')
                <!-- Kartu untuk Bill of Payments -->
                <div class="card border-light shadow-sm small-card">
                    <div class="card-body text-center">
                        <h6 class="card-title">
                            <i class="fas fa-file-invoice-dollar" style="color: #E90074;"></i> Bill of Payments
                        </h6>
                        <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $billsCount }}</span></p>
                        <p class="card-text text-muted">Lihat rekap pembayaran Anda di sini.</p>
                        <a href="{{ route('bill-of-payment.index') }}" class="btn btn-danger btn-sm" style="background-color: #E90074; color: white;">Lihat Rekap</a>
                    </div>
                </div>
            @endif
        </div>
        <style>
            /* CSS untuk mengatur tinggi kartu agar seragam */
            .small-card {
                width: 12rem; /* Lebar setiap kartu */
                font-size: 0.75rem; /* Ukuran font lebih kecil */
                margin: 0.5rem; /* Jarak antar kartu */
            }

            .small-card .card-body {
                display: flex;
                flex-direction: column;
                justify-content: space-between; /* Ruang di antara elemen dalam kartu */
                padding: 0.5rem; /* Padding kecil */
            }

            .small-card .btn {
                font-size: 0.7rem; /* Ukuran font tombol lebih kecil */
                padding: 0.2rem 0.4rem; /* Padding kecil untuk tombol */
                margin-top: auto; /* Pastikan tombol selalu berada di bagian bawah */
            }
        </style>
    </div>
</div>
@endsection
