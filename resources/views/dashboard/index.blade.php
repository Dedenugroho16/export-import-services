@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <div class="row">

        @if(auth()->user()->role === 'admin')
            <!-- Kartu untuk client -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-users fa-3x" style="color: #007bff;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">client</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data client Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat client</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Produk -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-box fa-3x" style="color: #28a745;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Produk</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data produk Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ url('/products') }}" class="btn btn-success btn-sm">Lihat Produk</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Komoditas -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-gem fa-3x" style="color: #ffc107;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Komoditas</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data komoditas Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Negara -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-flag fa-3x" style="color: #dc3545;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Negara</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola informasi negara di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ url('/countries') }}" class="btn btn-danger btn-sm">Lihat Negara</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Pengguna -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-user fa-3x" style="color: #17a2b8;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Pengguna</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data pengguna di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('users.index') }}" class="btn btn-info btn-sm">Lihat Pengguna</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Cabang -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-building fa-3x" style="color: #6f42c1;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Cabang</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data cabang di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('branches.index') }}" class="btn btn-purple btn-sm">Lihat Cabang</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Transaksi -->
            <div class="col-md-12 mb-4 d-flex justify-content-center"> 
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px; border: 2px solid white; width: 100%; margin: 0;"> <!-- Border putih diperlebar -->
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-receipt fa-3x" style="color: #17a2b8;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Transaksi</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola transaksi Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('proforma.create') }}" class="btn btn-info btn-sm">Lihat Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>


        @elseif(auth()->user()->role === 'operator')
            <!-- Kartu untuk client -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-users fa-3x" style="color: #007bff;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">client</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data client Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('clients.index') }}" class="btn btn-primary btn-sm">Lihat client</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Produk -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-box fa-3x" style="color: #28a745;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Produk</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data produk Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ url('/products') }}" class="btn btn-success btn-sm">Lihat Produk</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Komoditas -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-gem fa-3x" style="color: #ffc107;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Komoditas</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data komoditas Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ url('/commodities') }}" class="btn btn-warning btn-sm">Lihat Komoditas</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Negara -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-flag fa-3x" style="color: #dc3545;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Negara</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola informasi negara di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ url('/countries') }}" class="btn btn-danger btn-sm">Lihat Negara</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Cabang -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-building fa-3x" style="color: #6f42c1;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Cabang</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola data cabang di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('branches.index') }}" class="btn btn-purple btn-sm">Lihat Cabang</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu untuk Transaksi -->
            <div class="col-md-4 mb-4">
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px;">
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-receipt fa-3x" style="color: #17a2b8;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Transaksi</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola transaksi Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('proforma.create') }}" class="btn btn-info btn-sm">Lihat Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>

        @elseif(auth()->user()->role === 'director')
        <div class="col-md-12 mb-4 d-flex justify-content-center"> 
                <div class="card border-light shadow-sm" style="background-color: #f8f9fa; height: 160px; border: 2px solid white; width: 100%; margin: 0;"> <!-- Border putih diperlebar -->
                    <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="height: 100%;">
                        <h5 class="card-title">
                            <i class="fas fa-receipt fa-3x" style="color: #17a2b8;"></i>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">Transaksi</h6>
                        <p class="card-text" style="font-size: 0.85rem;">Kelola transaksi Anda di sini.</p>
                        <div class="mt-auto">
                            <a href="{{ route('proforma.create') }}" class="btn btn-info btn-sm">Lihat Transaksi</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

<style>
    .card {
        border-radius: 10px;
    }

    .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-info, .btn-purple {
        font-weight: bold;
        border-radius: 5px;
        margin-top: 10px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
        color: white;
    }

    .btn-warning:hover {
        background-color: #e0a800;
        color: white;
    }

    .btn-danger:hover {
        background-color: #c82333;
        color: white;
    }

    .btn-info:hover {
        background-color: #138496;
        color: white;
    }

    .btn-purple {
        background-color: #6f42c1;
        color: white;
    }
    
    .btn-purple:hover {
        background-color: #5a32a3;
        color: white;
    }
</style>

@endsection