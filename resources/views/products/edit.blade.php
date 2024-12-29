@extends('layouts.layout')
@section('title', 'Produk')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Form Section -->
        <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
            <div class="col-12">
                <div class="card mb-5">
                <div class="card-header text-white shadow-sm p-3" style="background-color: #0054a6;">
                        <h3 class="card-title">Edit Produk</h3>
                    </div>
                    <div class="card-body">
                        <!-- Display Success Message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('products.update', \App\Helpers\IdHashHelper::encode($product->id)) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                            <div class="mb-4">
                                <label for="code" class="form-label">Kode Produk</label>
                                <input type="text" id="code" name="code" class="form-control" value="{{ old('code', $product->code) }}" required>
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="name" class="form-label">Nama Produk</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="abbreviation" class="form-label">Singkatan Produk</label>
                                <input type="text" id="abbreviation" name="abbreviation" class="form-control" value="{{ old('abbreviation', $product->abbreviation) }}" required>
                                @error('abbreviation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <a href="javascript:void(0);" class="btn btn-outline-primary me-1" onclick="window.history.back();">Kembali</a>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
