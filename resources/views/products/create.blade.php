@extends('layouts.layout')

@section('content')
<div class="page-body">
    <div class="container-xl">

        <!-- Form Section -->
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card mb-5">
                    <div class="card-header text-white shadow-sm p-3" style="background-color: #182433;">
                        <h3 class="card-title">Tambah Data Produk</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('products.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Produk</label>
                                <input type="text" id="code" name="code" class="form-control" value="{{ old('code') }}" required>
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="abbreviation" class="form-label">Singkatan Produk</label>
                                <input type="text" id="abbreviation" name="abbreviation" class="form-control" value="{{ old('abbreviation') }}">
                                @error('abbreviation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
