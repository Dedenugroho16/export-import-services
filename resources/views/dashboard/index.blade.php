@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat Client</a>
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
                    <a href="{{ url('/products') }}" class="btn btn-success btn-sm">Lihat Produk</a>
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
                    <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
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
                    <a href="{{ url('/countries') }}" class="btn btn-danger btn-sm">Lihat Negara</a>
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
                    <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">Lihat Pengguna</a>
                </div>
            </div>

            <!-- Kartu untuk Cabang -->
            <div class="card border-light shadow-sm">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-building" style="color: #6f42c1;"></i> Branches
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $branchesCount }}</span></p>
                    <p class="card-text text-muted">Kelola data cabang di sini.</p>
                    <a href="{{ route('branches.index') }}" class="btn btn-secondary btn-sm">Lihat Cabang</a>
                </div>
            </div>

            <!-- Kartu untuk Transaksi -->
            <div class="card border-light shadow-sm full-width">
                <div class="card-body text-center">
                    <h6 class="card-title">
                        <i class="fas fa-receipt" style="color: #fd7e14;"></i> Transactions
                    </h6>
                    <p class="card-text">Jumlah: <span class="font-weight-bold">{{ $transactionsCount }}</span></p>
                    <p class="card-text text-muted">Kelola transaksi Anda di sini.</p>
                    <a href="{{ route('proforma.create') }}" class="btn btn-warning btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        @endif

    </div>

    <!-- Grafik -->
    <div class="mt-5">
        <h4 class="text-center">Statistik</h4>
        <canvas id="myChart"></canvas>
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

    /* CSS untuk grafik */
    #myChart {
        max-width: 100%;
        height: 400px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .full-width {
        grid-column: span 2; /* Atur kartu transaksi agar mengambil dua kolom */
    }
</style>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Clients', 'Products', 'Commodities', 'Countries', 'Users', 'Branches', 'Transactions'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $clientsCount }}, {{ $productsCount }}, {{ $commoditiesCount }}, {{ $countriesCount }}, {{ $usersCount }}, {{ $branchesCount }}, {{ $transactionsCount }}],
                backgroundColor: [
                    'rgba(0, 123, 255, 0.5)', // Biru
                    'rgba(40, 167, 69, 0.5)', // Hijau
                    'rgba(255, 193, 7, 0.5)', // Kuning
                    'rgba(220, 53, 69, 0.5)', // Merah
                    'rgba(23, 162, 184, 0.5)', // Biru Muda
                    'rgba(111, 66, 193, 0.5)', // Ungu
                    'rgba(253, 126, 20, 0.5)'  // Oranye
                ],
                borderColor: [
                    'rgba(0, 123, 255, 1)', // Biru
                    'rgba(40, 167, 69, 1)', // Hijau
                    'rgba(255, 193, 7, 1)', // Kuning
                    'rgba(220, 53, 69, 1)', // Merah
                    'rgba(23, 162, 184, 1)', // Biru Muda
                    'rgba(111, 66, 193, 1)', // Ungu
                    'rgba(253, 126, 20, 1)'  // Oranye
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Kategori'
                    }
                }
            }
        }
    });
</script>

@endsection
